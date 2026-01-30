<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Yajra\DataTables\DataTables;
use App\Models\Intake;
use App\Models\IntakeValues;
use App\Models\LeadNotes;
use App\Models\LeadStatus;
use App\Models\CaseType;
use App\Models\NotesCategory;
use App\User;
use Carbon\Carbon;
use Gate;

class NotesSearchController extends Controller
{
	/*
	*
	* Notes Search Form and List.
	*
	*/	
    public function index(Request $request)
    {
		abort_if(Gate::denies('notes_search_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$intake_values = [
			'status'             	=> LeadStatus::distinct()->pluck('title','id'),
			'case_type'             => CaseType::pluck('title', 'id'),
		];
		
		$staticDropdowns = [
			'users'                => User::all()->pluck('name', 'id'),
			'notes_category_list'  => NotesCategory::pluck('title', 'id'),
		];
		
		return view('admin.notes-search.index', array_merge(
			[
				'intake_values' => $intake_values,
			],
			$staticDropdowns
		));
    }
	
	/*
	*
	* Function to Fetch Notes Search Data List.
	*
	*/	
    public function getNotesSearchList(Request $request)
    {
		abort_if(Gate::denies('notes_search_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		if($request->ajax()) {
			$query = LeadNotes::with(['intake_value.case_type_value', 'intake_value.contact', 'intake_value.assignee_value', 'intake_value.owner_value']);
			
			if ($request->filled('filter_from')) {
				$query->whereDate('created_at', '>=', $request->filter_from);
			}

			if ($request->filled('filter_to')) {
				$query->whereDate('created_at', '<=', $request->filter_to);
			}
			
			if ($request->filled('filter_search')) {
				$query = $query->where(function ($qry) use ($request) {
					$qry->where('notes','like','%'.$request->filter_search.'%')
						  ->orWhere('attachment','like','%'.$request->filter_search.'%');
				});
			}
			
			if ($request->filled('filter_case_type')) {
				$caseTypes = (array) $request->filter_case_type;
				$query->whereHas('intake_value', function ($q) use ($caseTypes) {
					$q->whereIn('case_type', $caseTypes);
				});
			}

			if ($request->filled('filter_notes_category')) {
				$categoryIds = (array) $request->filter_notes_category;
				$query->whereIn('category_id', $categoryIds);
			}

			if ($request->filled('filter_user')) {
				$userIds = (array) $request->filter_user;
				$query->where(function ($q) use ($userIds) {
					$q->whereIn('user_id', $userIds)
					  ->orWhereHas('intake_value', function ($subQ) use ($userIds) {
						  $subQ->where(function ($innerQ) use ($userIds) {
							  $innerQ->whereIn('assignee', $userIds)
									 ->orWhereIn('owner', $userIds);
						  });
					  });
				});
			}

			
			return DataTables::of($query)
				->addIndexColumn()
				->addColumn('checkbox', function ($row) {
					return '<input type="checkbox" class="user-checkbox"value="'.$row->id.'">';
				})
				->addColumn('created', function ($row) {
					return $row->created_at->format('Y-m-d H:i:s');
				})
				->addColumn('user_name', function ($row) {
					return @$row->user->name ?? '';
				})
				->addColumn('client', function($row) {
					$intake_id = @$row->intake_id ?? '';
					$display_name = @$row->intake_value->contact->display_name ?? '';
					if($intake_id && $display_name) {
					return $intake_id
						? '<a target="_blank" href="'.route('admin.intakes.edit', $intake_id) .'" ><span style="color: gray!important">'.$intake_id . '</span><span class="mx-1">|</span><span>' . $display_name.'</span></a>'
						: '';
					}
					else {
						return '-';
					}
				})
				->addColumn('note_type', function ($row) {
					return @$row->category_value->title ?? trans('notes_search.no_category');
				})
				->addColumn('notes', function ($row) {
					return @$row->notes ?? '';
				})			
				->rawColumns(['checkbox', 'user_name', 'client', 'note_type'])
				->make(true);
		}
    }
	
	/*
	*
	* Function to export All Searched Notes.
	*
	*/
	public function exportSearchedNotes(Request $request)
	{
		abort_if(Gate::denies('notes_search_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		$query = LeadNotes::with(['intake_value.case_type_value', 'intake_value.contact', 'intake_value.assignee_value', 'intake_value.owner_value', 'user', 'category_value']);

		if ($request->filled('filter_from')) {
			$query->whereDate('created_at', '>=', $request->filter_from);
		}
		if ($request->filled('filter_to')) {
			$query->whereDate('created_at', '<=', $request->filter_to);
		}
		if ($request->filled('filter_search')) {
			$query->where(function ($qry) use ($request) {
				$qry->where('notes','like','%'.$request->filter_search.'%')
					->orWhere('attachment','like','%'.$request->filter_search.'%');
			});
		}
		if ($request->filled('filter_case_type')) {
			$caseTypes = (array) $request->filter_case_type;
			$query->whereHas('intake_value', fn($q) => $q->whereIn('case_type', $caseTypes));
		}
		if ($request->filled('filter_notes_category')) {
			$query->whereIn('category_id', (array) $request->filter_notes_category);
		}
		if ($request->filled('filter_user')) {
			$userIds = (array) $request->filter_user;
			$query->where(function ($q) use ($userIds) {
				$q->whereIn('user_id', $userIds)
					->orWhereHas('intake_value', function ($subQ) use ($userIds) {
						$subQ->whereIn('assignee', $userIds)
							 ->orWhereIn('owner', $userIds);
					});
			});
		}

		$data = $query->get();

		$filename = 'Notes-' . now()->format('Y-m-d-h-i-s-A') . '.csv';

		return new StreamedResponse(function () use ($data) {
			$output = fopen('php://output', 'w');
			fputcsv($output, ['Date/Time', 'User Name', 'Lead Id', 'Client', 'Note Type', 'Notes']);

			foreach ($data as $row) {
				fputcsv($output, [
					$row->created_at->format('Y-m-d H:i:s'),
					optional($row->user)->name,
					$row->intake_id,
					optional($row->intake_value->contact)->display_name,
					optional($row->category_value)->title ?? __('notes_search.no_category'),
					$row->notes
				]);
			}
			fclose($output);
		}, 200, [
			"Content-Type" => "text/csv",
			"Content-Disposition" => "attachment; filename=\"$filename\"",
			"Pragma" => "no-cache",
			"Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
			"Expires" => "0"
		]);
	}

}