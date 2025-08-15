<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;
use setasign\Fpdi\Fpdi;
use App\Helpers\GeneralFunctions;
use App\Models\IntakeValues;
use App\Models\LeadStatus;
use App\Models\CaseType;
use App\Models\DocumentCategory;
use App\Models\DocumentFolder;
use App\Models\DocumentPath;
use App\Models\Documents;
use App\Models\DocumentPrintQueue;
use App\Models\Intake;
use App\Models\Contact;
use App\Models\Activity;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Auth;
use Gate;
use DB;

class DocumentsController extends Controller
{	
	protected $perPage;

	public function __construct()
	{
		$this->perPage = 10;
	}	
	
	/*
	*
	* Display a Main Documents.
	*
	*/	 
	public function index(Request $request)
    {		
		abort_if(Gate::denies('intake_documents_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		// Load all dropdown-type values and group by 'type'
		$intake_values = IntakeValues::all()->groupBy('type');
		
		// Add additional dropdowns to the intake_values array
		$additionalDropdowns = [
			'status'             	=> LeadStatus::distinct()->pluck('title','id'),
			'case_type'             => CaseType::pluck('title', 'id'),
		];

		foreach ($additionalDropdowns as $key => $values) {
			$intake_values[$key] = $values;
		}
		
		$groupedDPQ = DocumentPrintQueue::selectRaw('DATE(created_at) as doc_date')
		->selectRaw('COUNT(*) as total')
		->selectRaw('SUM(CASE WHEN is_printed = 1 THEN 1 ELSE 0 END) as printed')
		->selectRaw('SUM(CASE WHEN is_printed = 0 OR is_printed IS NULL THEN 1 ELSE 0 END) as not_printed')
        ->groupBy('doc_date')
        ->orderByDesc('doc_date')
        ->paginate($this->perPage);

		$printQueueDocByDate = [];

		foreach ($groupedDPQ as $group) {
        $queueItems = DocumentPrintQueue::with('document')
				->whereDate('created_at', $group->doc_date)
				->get();

			$printQueueDocByDate[$group->doc_date] = [
				'total' => $group->total,
				'printed' => $group->printed,
				'not_printed' => $group->not_printed,
				'items' => $queueItems,
			];
		}
	
		// Other dropdown lists
		$staticDropdowns = [
			'created_by_list' => [ auth()->user()->id =>auth()->user()->name ],
			'document_category'     => DocumentCategory::pluck('title', 'id'),
			'document_folder_list' => DocumentFolder::pluck('folder_name', 'id'),
			'printQueueDocByDate' => $printQueueDocByDate,
			'printQueueDocPaginate' => $groupedDPQ,
		];

		$exportDataRoute = route('admin.main-document.exportDocuments');
		$date_range_options = [
			//'all' => trans('global.all_time'),
			//'today' => trans('global.today'),
			//'last_week' => trans('global.last_week'),
			'current_month' => trans('global.current_month'),
			'all_dates' => trans('global.all_dates'),
			//'last_month' => trans('global.last_month'),
			//'last_year' => trans('global.last_year'),
			'custom' => trans('global.custom'),
		];
		
		return view('admin.documents.index', array_merge(
			[
				'intake_values' => $intake_values,
				'exportDataRoute' => $exportDataRoute ?? '',
				'date_range_options' => $date_range_options ?? [],
			],
			$staticDropdowns
		));
    }
	
	/*
	*
	* Print Queue Documents Grouped.
	*
	*/	 
	public function printQueueGroupedByDate(Request $request)
    {		
		abort_if(Gate::denies('intake_documents_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$groupedDPQ = DocumentPrintQueue::selectRaw('DATE(created_at) as doc_date')
		->selectRaw('COUNT(*) as total')
		->selectRaw('SUM(CASE WHEN is_printed = 1 THEN 1 ELSE 0 END) as printed')
		->selectRaw('SUM(CASE WHEN is_printed = 0 OR is_printed IS NULL THEN 1 ELSE 0 END) as not_printed')
        ->groupBy('doc_date')
        ->orderByDesc('doc_date')
        ->paginate($this->perPage);

		$printQueueDocByDate = [];

		foreach ($groupedDPQ as $group) {
        $queueItems = DocumentPrintQueue::with('document')
				->whereDate('created_at', $group->doc_date)
				->get();

			$printQueueDocByDate[$group->doc_date] = [
				'total' => $group->total,
				'printed' => $group->printed,
				'not_printed' => $group->not_printed,
				'items' => $queueItems,
			];
		}
		
		if($request->ajax()) {
			return view('partials.print-queue-accordion', [
				'printQueueDocByDate' => $printQueueDocByDate,
				'printQueueDocPaginate' => $groupedDPQ,
			])->render();
		}
		
		abort(404);
    }
	
	/*
	*
	* Function to export All Main Documents table records according to date range.
	*
	*/
	public function exportDocument(Request $request)
	{
		abort_if(Gate::denies('intake_documents_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		// Validate request
		$request->validate([
			'from_date' => 'required|date',
			'to_date' => 'required|date|after_or_equal:from_date',
		]);

		// Format dates
		$from = (new \DateTime($request->from_date))->format("Y-m-d");
		$to = (new \DateTime($request->to_date))->format("Y-m-d");

		// Fetch documents
		$documents = Documents::with(['intake_value.case_type_value', 'intake_value.marketing_source_value', 'intake_value.contact', 'document_category_value'])
			->whereBetween(DB::raw('DATE(created_at)'), [$from, $to])
			->get()
			->map(function ($record) {
				$record->formated_created_at = Carbon::parse($record->created_at)->format('Y-m-d H:i:s');
				$record->formated_updated_at = Carbon::parse($record->updated_at)->format('Y-m-d H:i:s');
				return $record;
			});

		// Prepare CSV download
		$filename = date('d-m-Y') . '_' . rand(10, 100) . '_Clauson_Disability_Document_Report' . '.csv';

		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=' . $filename);
		header('Pragma: no-cache');
		header('Expires: 0');

		$output = fopen('php://output', 'w');

		// CSV Header
		fputcsv($output, ['Lead Id', 'Contact', 'Document Name', 'Related Lead/Case', 'Category Name', 'Date Modified', 'Last Modified By', 'Created By' , 'Size', 'Folder Path', 'Marketing Source', 'Case Type', 'Status']);

		// CSV Rows
		foreach ($documents as $row) {
			$intake_id = @$row->intake_id ?? '';
			$display_name = @$row->intake_value->contact->display_name ?? '';	
			$category = @$row->document_category_value->title ?? '';
			
			fputcsv($output, [
				$row->intake_id,
				optional($row->intake_value->contact)->display_name,
				$row->document_name,
				$intake_id . '-' . $display_name,
				$category,
				$row->updated_at ? \Carbon\Carbon::parse($row->updated_at)->format('Y-m-d') : '',
				$row->modified_by ? @$row->modified_by->name : 'System',
				$row->created_by ? @$row->created_by->name : 'System',
				$row->document_size,
				$row->document_path,
				optional($row->intake_value->marketing_source_value)->value,
				optional($row->intake_value->case_type_value)->title,
				optional($row->intake_value->status_value)->title
			]);
		}

		fclose($output);
		exit();
	}

	
	/*
	*
	* Function to Main Documents List.
	*
	*/	
	public function documentList(Request $request)
	{
		abort_if(Gate::denies('intake_documents_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		[$startDate, $endDate] = $this->getDateRangeFromKeyword($request->get('date_range'));
		
		$lead_id = $request->get('lead_id');
		$folderId = $request->get('folder_id');
		$viewMode = $request->get('view_mode', 'folder'); // default = folder view
		
		if(!$folderId) {
			$folderId = DocumentPath::where('name', 'Documents')->value('id');
		}
		
		if ($request->ajax()) {
			$combined = collect();

			if ($viewMode === 'folder') {
				DocumentPath::with(['documents', 'children'])
					->where('intake_id', '>', 0)
					->when($folderId > 0, function ($query) use ($folderId) {
						return $query->where('parent_id', $folderId);
					})
					->chunk(1000, function ($foldersChunk) use (&$combined, $request) {
						foreach ($foldersChunk as $folder) {
							if ($request->show_empty_folder !== '1') {
								if ($folder->documents->isEmpty() && $folder->children->isEmpty()) {
									continue;
								}
							}

							$combined->push((object)[
								'id' => $folder->id,
								'type' => 'folder',
								'document_name' => $folder->name,
								'document_path' => null,
								'document_size' => null,
								'document_category_value' => null,
								'document_type' => 'Folder',
								'intake_id' => $folder->intake_id,
								'intake_value' => null,
								'description' => null,
								'document_modified' => $folder->updated_at,
								'updated_at' => $folder->updated_at,
								'modified_by' => null,
							]);
						}
					});
			}

			// === FILE FILTERING ===
			$data = ($request->is_deleted_list === '1' ? Documents::onlyTrashed() : Documents::query());

			$data = $data->with([
				'intake_value.case_type_value',
				'intake_value.marketing_source_value',
				'intake_value.contact',
				'document_category_value',
				'modified_by',
			]);
			
			if ($viewMode === 'folder') {
				$data = $data->when($folderId, fn($q) => $q->where('path_id', $folderId));
			}
			
			$data = $data->when($request->lead_id, fn($q) => $q->where('intake_id', $request->lead_id));

			if ($request->date_range && $request->date_range !== 'all') {
				$startDate = Carbon::parse(explode(' - ', $request->date_range)[0])->startOfDay();
				$endDate = Carbon::parse(explode(' - ', $request->date_range)[1])->endOfDay();
				$data = $data->whereBetween('created_at', [$startDate, $endDate]);
			}

			$data = $data->when($request->document_category, function ($query, $document_category) {
				$document_category = array_filter($document_category, fn($v) => $v !== 'all');
				if (!empty($document_category)) {
					$query->whereHas('document_category_value', fn($q) => $q->whereIn('id', $document_category));
				}
			});

			$data = $data->when($request->case_type, function ($query, $case_type) {
				$case_type = array_filter($case_type, fn($v) => $v !== 'all');
				if (!empty($case_type)) {
					$query->whereHas('intake_value', fn($q) => $q->whereIn('case_type', $case_type));
				}
			});

			$data = $data->when($request->status, function ($query, $status) {
				$status = array_filter($status, fn($v) => $v !== 'all');
				if (!empty($status)) {
					$query->whereHas('intake_value', fn($q) => $q->whereIn('status', $status));
				}
			});

			$data = $data->when($request->marketing_source, function ($query, $marketing_source) {
				$marketing_source = array_filter($marketing_source, fn($v) => $v !== 'all');
				if (!empty($marketing_source)) {
					$query->whereHas('intake_value', fn($q) => $q->whereIn('marketing_source', $marketing_source));
				}
			});

			$data = $data->when($request->search_document, function ($query, $search) {
				$query->where(function ($q) use ($search) {
					$q->where('document_name', 'like', "%{$search}%")
						->orWhereHas('document_category_value', fn($q2) => $q2->where('title', 'like', "%{$search}%"))
						->orWhereHas('intake_value.case_type_value', fn($q3) => $q3->where('title', 'like', "%{$search}%"))
						->orWhereHas('intake_value.contact', fn($q4) => $q4->where('display_name', 'like', "%{$search}%"))
						->orWhereHas('modified_by', fn($q5) => $q5->where('name', 'like', "%{$search}%"));
				});
			});

			$data = $data->orderBy('id', 'desc');

			// Chunk and merge files into $combined
			$data->chunk(1000, function ($filesChunk) use (&$combined) {
				foreach ($filesChunk as $file) {
					$combined->push($file);
				}
			});

			// === RETURN TO DATATABLE ===
			return DataTables::of($combined)
				->addColumn('checkbox', function ($row) {
					return '<input type="checkbox" class="user-checkbox" value="'.$row->id.'">';
				})
				->editColumn('document_name', function ($row) {
					$document_dir_path = @$row->document_path ?? '';
					$document_name = @$row->document_name ?? '';
					$case_id = @$row->intake_value->case_type ?? '';
					$contact_id = @$row->intake_value->contact_id ?? '';
					$attach_url = asset('uploads/' . $row->document_path . '/' . $document_name);
					$docNameWithoutExt = pathinfo($document_name, PATHINFO_FILENAME);
					if($row->type == 'folder') {
						return '<div><a href="javascript:;">' . $document_name . '</a></div>
							<div class="d-flex justify-content-left align-items-center">
								<div class="mx-1"><a href="javascript:;" class="folder-btn" data-lead_id="'.$row->intake_id.'" data-folder-id="'.$row->id.'" data-case_id="'.$case_id.'" data-client_id="'.$contact_id.'" >'.trans('documents.view').'</a></div>
								<div class="mx-1"><a target="_blank" href="'.$attach_url.'" download >'.trans('documents.download').'</a></div>
							</div>';
					}
					else {
						/*
						$pathArray = GeneralFunctions::getFolderPathArray($row->path_id);
						$path_route = 'in ';
						if(isset($pathArray) && !empty($pathArray)) {
							foreach($pathArray as $path) {
								if($path['name'] == 'Documents') {
									$path_route = $path_route .'<a class="folder-btn" href="javascript:;" data-lead_id="0" data-folder-id="0" data-case_id="0" data-client_id="" >'.$path['name'].'</a>/';
								}
								else {
									$path_route = $path_route .'<a class="folder-btn" href="javascript:;" data-lead_id="'.$row->intake_id.'" data-folder-id="'.$path['id'].'" data-case_id="'.$case_id.'" data-client_id="'.$contact_id.'" >'.$path['name'].'</a>/';
								}
							} 
						}
						$path_route = rtrim($path_route, '/');
						*/
						return '<div class="d-flex justify-content-left align-items-center"><a target="_blank" href="'.$attach_url.'" class="filename" data-id="'.$row->id.'" >' . $document_name . '</a><input type="text" class="form-control rename-input d-none" value="' . $docNameWithoutExt . '" data-id="'.$row->id.'" /><i class="far fa-check-circle ph-check-circle ok-rename-btn d-none" data-id="'.$row->id.'" style="font-size:30px;color:green"></i><i class="far fa-times-circle ph-x-circle discard-rename-btn d-none" data-id="'.$row->id.'" style="font-size:30px;color:red"></i></div>
							<div class="document-details-'.$row->id.' link-primary" style="display:none;">
								<a class="folder-btn" href="javascript:;" data-lead_id="'.$row->intake_id.'" data-folder-id="'.$row->path_id.'" data-case_id="'.$case_id.'" data-client_id="'.$contact_id.'" >in '.$document_dir_path.'</a>
							</div>
							<div class="d-flex justify-content-left align-items-center">
								<div class="me-1"><a href="javascript:;" >'.trans('documents.edit').'</a></div>
								<div class="mx-1"><a target="_blank" href="'.$attach_url.'" >'.trans('documents.view').'</a></div>
								<div class="mx-1"><a onclick="showDocumentDetails('.$row->id.')" href="javascript:;" >'.trans('documents.details').'</a></div>
								<div class="mx-1"><a target="_blank" href="'.$attach_url.'" download >'.trans('documents.download').'</a></div>
								<div class="mx-1"><a href="javascript:;" class="edit-name" data-id="'.$row->id.'" >'.trans('documents.rename').'</a></div>
							</div>';
					}
				})
				->addColumn('related_lead_case', function($row) {
					$intake_id = @$row->intake_id ?? '';
					$display_name = @$row->intake_value->contact->display_name ?? '';
					if($intake_id && $display_name) {
					return $intake_id
						? '<a target="_blank" href="'.route('admin.intakes.edit', $intake_id) .'" >'.$intake_id . '-' . $display_name.'</a>'
						: '';
					}
					else {
						return '-';
					}
				})
				->addColumn('document_category', fn($row) => @$row->document_category_value->title ?? '')
				->addColumn('case_type', fn($row) => @$row->intake_value->case_type_value->title ?? '')
				->addColumn('date_modified', fn($row) => $row->updated_at ? Carbon::parse($row->updated_at)->format('Y-m-d') : '')
				->addColumn('modified_by', fn($row) => @$row->modified_by ? @$row->modified_by->name : 'System')
				->rawColumns(['checkbox', 'document_name', 'related_lead_case', 'case_type'])
				->make(true);
		}
	}
	
	/*
	*
	* Function to get Print Queue Doc Detail List.
	*
	*/	
	public function printQueueDocDetailsList(Request $request)
	{
		abort_if(Gate::denies('intake_documents_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		$document_id = $request->get('docId');
		$document_template_id = $request->get('documentTemplateId');
		$file_info_id = $request->get('fileInformationId');
		$create_date = $request->get('createDate');
		$page_num = $request->get('pageNum');
		$page_size = $request->get('pageSize');
		
		$query = Documents::query();
		$query = $query->where('id', $document_id);
		$query = $query->with([
			'intake_value.contact',
			'intake_value.case_type_value',
		]);
		
		return DataTables::of($query)
				->addColumn('checkbox', function ($row) {
					return '<input type="checkbox" class="user-checkbox" name="pq_selected_ids[]" value="'.$row->id.'">';
				})
				->addColumn('first_name', function ($row) {
					return @$row->intake_value->contact->first_name ?? '';
				})
				->addColumn('last_name', function ($row) {
					return @$row->intake_value->contact->last_name ?? '';
				})
				->addColumn('document_created', function ($row) {
					return $row->created_at ? Carbon::parse($row->created_at)->format('Y-m-d') : '';
				})
				->addColumn('mail_merge_status', function ($row) {
					return 'Ready to Print';
				})
				->addColumn('type_of_case', function ($row) {
					return @$row->intake_value->case_type_value->title ?? '';
				})
				->addColumn('mailing_address_1', function ($row) {
					return $this->getAddressField($row, 'address_1');
				})
				->addColumn('mailing_address_2', function ($row) {
					return $this->getAddressField($row, 'address_2');
				})
				->addColumn('city', function ($row) {
					return $this->getAddressField($row, 'city');
				})
				->addColumn('state', function ($row) {
					return '-';
				})
				->addColumn('zip_code', function ($row) {
					return $this->getAddressField($row, 'zip');
				})
				->addColumn('action', function ($row) {
					return '-';
				})
				->rawColumns(['checkbox','action'])
				->make(true);
	}
	
	/*
	*
	* Function to Print All Selected Queued Documents.
	*
	*/
	public function printSelectedQueuedDocuments(Request $request)
    {
		abort_if(Gate::denies('intake_documents_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$type = $request->type ?? '';
		$selected_ids = $request->selected_ids ?? [];
		$print_format = $request->print_format ?? 'pdf';
		
		if($print_format=='pdf')
			{ 
				$documents = Documents::whereIn('id', $selected_ids)->get();

				if ($documents->isEmpty()) {
					return response()->json([
						'status' => 'error',
						'message' => 'No Documents Found',
					]);
				}
				
				$pdf = new Fpdi();
				
				foreach($documents as $document)
				{
					$document_id = $document->id;
					$root_dir = 'uploads/';
					$path = '';
					$pathArray = GeneralFunctions::getFolderPathArray($document->path_id);
					if($pathArray) {
						$path = implode('/', array_column($pathArray, 'name'));
					}
					if($path) {
						$path = $root_dir.$path; 
					}
					
					$filePath = public_path($path . '/' . $document->document_name);
					
					if (!file_exists($filePath)) continue;
					
					$pageCount = $pdf->setSourceFile($filePath);
					
					for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
						$templateId = $pdf->importPage($pageNo);
						$size = $pdf->getTemplateSize($templateId);

						$pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
						$pdf->useTemplate($templateId);
					}
					
				}
				
				// Get output as string
				$output = $pdf->Output('S'); // 'S' returns the PDF as a string
				
				return response()->json([
					'status' => 'success',
					'type' => 'pdf',
					'pdf' => base64_encode($output),
					'filename' => 'documents_list-data.pdf',
				]);
			}
		else 
			{
				return response()->json([
					'status' => 'error', 	
					'message' => 'Invalid Print Format', 	
				]);
			}
    }
	
	/*
	*
	* Function to Delete All Selected Queued Documents.
	*
	*/
	public function deleteSelectedQueuedDocuments(Request $request)
    {
		abort_if(Gate::denies('intake_documents_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$request->validate([
			'selected_ids' => 'required|array',
			'selected_ids.*' => 'integer|exists:documents,id',
			
		]);
		
		$documents = Documents::whereIn('id',$request->selected_ids)->get();
		
		if($documents)
		{
			foreach($documents as $document)
			{
				$document_id = $document->id;
				$root_dir = 'uploads/';
				$path = '';
				$pathArray = GeneralFunctions::getFolderPathArray($document->path_id);
				if($pathArray) {
					$path = implode('/', array_column($pathArray, 'name'));
				}
				if($path) {
					$path = $root_dir.$path; 
				}
				
				//Delete file from public/storage
				$filePath = public_path($path . '/' . $document->document_name);
				if(file_exists($filePath)) {
					//unlink($filePath);
				}
				
				//Delete Record
				$document->delete();
				$printQueue = DocumentPrintQueue::where('document_id',$document_id)->first();
				if($printQueue)
				{
					$printQueue->delete();
				}
			}
			return response()->json([
				'status' => 'success', 
				'message' => 'Selected Documents Deleted Successfully'
			]);
		}
		else 
		{
			return response()->json([
				'status' => 'error', 	
				'message' => 'Documents not Exists', 	
			]);
		}
    }
	
	
	/*
	*
	* Function to get Folder Path.
	*
	*/
	public function getFolderPath($id)
	{
		abort_if(Gate::denies('intake_documents_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$pathArray = GeneralFunctions::getFolderPathArray($id);

		return response()->json([
			'path' => $pathArray
		]);
	}
	
	/**
	*
	* Helper to extract the first non-null address field
	*
	*/
	private function getAddressField($row, $field)
	{
		$addresses =@$row->intake_value->contact->addresses ?? null;
		if($addresses)
		{
			foreach ($addresses as $address) {
				if (!empty($address->$field)) {
					return $address->$field;
				}
			}
		}
		return '-';
	}
	
	/*
	*
	* Function to get Date Range From Keyword.
	*
	*/
	private function getDateRangeFromKeyword($keyword) {
		switch ($keyword) {
			case 'today':
				return [Carbon::today(), Carbon::now()];
			case 'last_week':
				return [Carbon::now()->subWeek(), Carbon::now()];
			case 'current_month':
				return [Carbon::now()->startOfMonth(), Carbon::now()];
			case 'last_month':
				return [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()];
			case 'last_year':
				return [Carbon::now()->subYear()->startOfYear(), Carbon::now()->subYear()->endOfYear()];
			default:
				//return [Carbon::minValue(), Carbon::now()];
				return [null, null];
		}
	}
}