<?php

namespace App\Http\Controllers\Admin\Lead;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Helpers\GeneralFunctions;
use App\Models\Documents;
use App\Models\LeadNotes;
use App\Models\Intake;
use App\Models\DocumentFolder;
use App\Models\DocumentPath;
use App\Models\Activity;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Auth;
use Gate;
use DB;

class NotesController extends Controller
{		
	/*
	*
	* Function to save Lead Notes in a table.
	*
	*/
	public function store(Request $request)
	{
		abort_if(Gate::denies('intake_notes_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		if (!$request->ajax()) {
			return response()->json([
				'status' => 'error',
				'message' => 'Invalid request type'
			], 400);
		}

		$validator = \Validator::make($request->all(), [
			'lead_id' => 'required|integer|min:1',
			'category_id' => 'nullable|integer',
			'notes' => 'nullable|string',
			'notes_attachment' => 'nullable|file|mimes:jpg,png,pdf,docx|max:2048',
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => 'validation_error',
				'message' => 'Validation Failed',
				'errors' => $validator->errors(),
			]);
		}
		
		$docUploadObj = new \App\Http\Controllers\Admin\DocumentUploadController();
		$docUploadResponse = $docUploadObj->documentUpload($request);
		$docUplResp = $docUploadResponse->getData();
		$document_path = @$docUplResp->data->document_path ?? null;
		$document_name = @$docUplResp->data->document_name ?? null;
		$attachment = $document_path.'/'.$document_name;
		$leadNotes = LeadNotes::create([
			'intake_id'   => $request->lead_id,
			'user_id'     => auth()->id(),
			'category_id' => $request->category_id,
			'notes'       => $request->notes,
			'attachment'  => $attachment,
		]);

		Activity::log(
			'lead_notes',
			'create',
			"Lead Notes has been created with id - {$leadNotes->id}",
			[
				'details' => $leadNotes,
				'intake_id' => $request->lead_id
			]
		);

		return response()->json([
			'status' => 'success',
			'message' => 'Notes added successfully'
		]);
	}
	
	/*
	*
	* Function to Fetch Notes List.
	*
	*/	
    public function leadNotesList(Request $request)
    {
		abort_if(Gate::denies('intake_notes_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = $request->get('lead_id');
		$search_notes = $request->get('search_notes');
		$notes_category = $request->get('notes_category');
		if($request->ajax()) {
			$data = LeadNotes::where('intake_id',$lead_id);
			if(!empty($notes_category)) {
				if(in_array('all',$notes_category)) { } else {
					$notes_category = array_filter($notes_category, fn($value) => $value !=='all');
					$data = $data->whereIn('category_id',$notes_category);
				}
			}
			if(!empty($search_notes)) {				
				$data = $data->where(function ($query) use ($search_notes) {
					$query->where('notes','like','%'.$search_notes.'%')
						  ->orWhere('attachment','like','%'.$search_notes.'%');
				});
			}
			$data->orderby('id', 'desc');
			return DataTables::of($data)
				->addColumn('user_name', function ($row) {
					return @$row->user->name ?? '';
				})
				->addColumn('category', function ($row) {
					return @$row->category_value->title ?? '';
				})
				->addColumn('notes', function ($row) {
					return @$row->notes ?? '';
				})
				->addColumn('attachment', function ($row) {
					if($row->attachment) {
						$attach_url = asset('uploads/'.$row->attachment);
						return '<div class="d-flex justify-content-left align-items-center"><a href="'.$attach_url.'" target="_blank" title="'.trans('notes.print_note_to_pdf').'" class="far fa-print ph-printer text-dark"></a>&nbsp;<a href="javascript:;" title="'.trans('notes.edit').'" class="far fa-pencil-alt ph-pencil text-dark editPopupNotesBtn" data-id="'.$row->id.'"></a>&nbsp;<a href="javascript:;" title="'.trans('notes.pin').'" class="far fa-thumbtack ph-push-pin text-dark addEditNotesPinBtn" data-id="'.$row->id.'"></a></div>';
					}
					return '';
				})
				->addColumn('notes_date', function ($row) {
					return $row->created_at ? Carbon::parse($row->created_at)->format('Y-m-d') : '';
				})
				->rawColumns(['notes_date','attachment'])
				->make(true);
		}
    }
	
	/*
	*
	* Function to get Notes Details.
	*
	*/	
    public function notesDetails(Request $request)
    {
		abort_if(Gate::denies('intake_notes_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$notes_id = $request->id;
		if($request->ajax()) {
			$notes_details = LeadNotes::findOrFail($notes_id);
			if($notes_details) {	
				$data = $notes_details->toArray();
				return response()->json([
					'status' => 'success',
					'message' => 'Details Fetched',
					'data' => $data
				]);
			}
			else {
				return response()->json([
					'status' => 'error',
					'message' => 'Details Not Found'
				]);
			}
		}
	}
	
	/*
	*
	* Function to update Notes with Ajax in a table.
	*
	*/
	public function updateNotes(Request $request)
	{
		abort_if(Gate::denies('intake_notes_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		if (!$request->ajax()) {
			return response()->json([
				'status' => 'error',
				'message' => 'Invalid request type'
			], 400);
		}
		
		$validator = \Validator::make($request->all(), [
			'notes_id' => 'required|integer|min:1',
			'lead_id' => 'required|integer|min:1',
			'category_id' => 'nullable|integer',
			'notes' => 'nullable|string',
			'notes_attachment' => 'nullable|file|mimes:jpg,png,pdf,docx|max:2048',
		]);
		
		if ($validator->fails()) {
			return response()->json([
				'status' => 'validation_error',
				'message' => 'Validation Failed',
				'errors' => $validator->errors(),
			]);
		}
		
		$notesDetails = LeadNotes::find($request->notes_id);

		if (!$notesDetails) {
			return response()->json([
				'status' => 'error',
				'message' => 'Notes not found',
			]);
		}

		$oldData = $notesDetails->toArray();
		
		$docUploadObj = new \App\Http\Controllers\Admin\DocumentUploadController();
		$docUploadResponse = $docUploadObj->documentUpload($request);
		$docUplResp = $docUploadResponse->getData();
		$document_path = @$docUplResp->data->document_path ?? null;
		$document_name = @$docUplResp->data->document_name ?? null;
		$attachment = $document_path.'/'.$document_name;
		
		$updateData = [
			'intake_id'   => $notesDetails->intake_id,
			'user_id'     => auth()->id(),
			'category_id' => $request->category_id,
			'notes'       => $request->notes,
			'attachment'  => $attachment,
		];
		
		$notesDetails->update($updateData);

		Activity::log(
			'notes',
			'update',
			"Notes Details Id - {$notesDetails->id} has been updated",
			[
				'details' => [
								'old' => $oldData,
								'new' => $updateData
							 ],
				'intake_id' => $notesDetails->intake_id
			]
		);

		return response()->json([
			'status' => 'success',
			'message' => 'Notes updated successfully',
		]);
	}
	
	/*
	*
	* Function to update Notes Pinned Status.
	*
	*/	
    public function updateNotesPinnedStatus(Request $request)
	{
		abort_if(Gate::denies('intake_notes_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		if (!$request->ajax()) {
			return response()->json([
				'status' => 'error',
				'message' => 'Invalid request type.',
			], 400);
		}

		$notesId = $request->input('notes_id');

		if (!$notesId) {
			return response()->json([
				'status' => 'error',
				'message' => 'Note ID is required.',
			]);
		}

		$note = LeadNotes::find($notesId);

		if (!$note) {
			return response()->json([
				'status' => 'error',
				'message' => 'Note not found.',
			]);
		}

		$note->is_pinned = !$note->is_pinned;
		$note->save();

		return response()->json([
			'status' => 'success',
			'message' => $note->is_pinned ? 'Note pinned' : 'Note unpinned',
		]);
	}

}