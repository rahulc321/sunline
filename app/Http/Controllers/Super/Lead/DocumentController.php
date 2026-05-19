<?php

namespace App\Http\Controllers\Admin\Lead;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Helpers\GeneralFunctions;
use App\Models\Documents;
use App\Models\ESignDocuments;
use App\Models\ESignDocumentStatus;
use App\Models\DocumentCategory;
use App\Models\DocumentFolder;
use App\Models\DocumentPath;
use App\Models\Intake;
use App\Models\Contact;
use App\Models\Activity;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Auth;
use Gate;
use DB;

class DocumentController extends Controller
{		
	/*
	*
	* Function to save Document in a table.
	*
	*/
	public function store(Request $request)
	{
		abort_if(Gate::denies('intake_documents_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = $request->lead_id;
		$assigned_by = auth()->user()->id;
		
		
		if($request->ajax()) {
			if($lead_id>0) {
				$document = Documents::create(['intake_id'=>$lead_id]);
					
				// Log the activity
				Activity::log(
					'documents', 
					'create', 
					"Documents: {$document->id}",
					[
						'details' => $document,
						'intake_id' => $lead_id
					]  
				);
	
				return response()->json([
					'status' => 'success',
					'message' => 'Document uploaded successfully'
				]);
			}
			else {
				return response()->json([
					'status' => 'error',
					'message' => 'Required field is empty'
				]);
			}
		}
    }
	
	/*
	*
	* Function to Fetch Documents List.
	*
	*/	
	public function leadDocumentList(Request $request)
	{ 
		abort_if(Gate::denies('intake_documents_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = $request->get('lead_id');
		$folderId = $request->get('folder_id');
		$dFolderId = $request->get('d_folder_id');
		$viewMode = $request->get('view_mode', 'folder'); // default = folder view
		
		$root_document_folder_id = null;
		if($lead_id>0) {
			$lead_data = Intake::find($lead_id);
			$contact_data = Contact::find($lead_data->contact_id);
			if(isset($contact_data) && !empty($contact_data))
			{
			  $current_folder_name = trim($contact_data->display_name);
			  $current_folder_name = GeneralFunctions::generateNames($current_folder_name);
			  $folderDetails = GeneralFunctions::getFolderDetails($lead_id.'-'.$current_folder_name, 'name');
			  $root_document_folder_id = $folderDetails['id'] ?? null;
			}
		}
		
		if(!$root_document_folder_id) {
			$data = Documents::where('intake_id', $lead_id);			
			$data->orderby('id', 'desc');

			return DataTables::of($data)
				->addColumn('document_category', function ($row) {
					return @$row->document_category_value->title ?? '';
				})
				->addColumn('document_modified', function ($row) {
					return Carbon::parse($row->updated_at)->format('Y-m-d H:i:s');
				})
				->addColumn('document_type', function () {
					return 'Folder';
				})
				->addColumn('contact_name', function ($row) {
					$contact = @$row->intake_value->contact ?? null;
					if (!$contact) return '';

					return $contact->display_name ?? trim("{$contact->first_name} {$contact->last_name}");
				})
				->rawColumns(['document_type', 'document_category'])
				->make(true);
			
		}
		else {
			if(!$folderId) {
				if($dFolderId) {
					$dFolderName = DocumentFolder::where('id', $dFolderId)->value('folder_name');
					$folderId = DocumentPath::where('intake_id', $lead_id)->where('name', $dFolderName)->value('id');
				}
				else {
					$folderId = $root_document_folder_id;
				}
			}
		}

		$combined = collect();

		if ($viewMode === 'folder') {
			// Show folders + files
			$folders = DocumentPath::where('parent_id', $folderId);
			
			if ($request->show_empty_folder !== '1') {
				$folders->where(function ($query) {
					$query->whereHas('documents')
						  ->orWhereHas('children');
				});
			}
			
			$folders = $folders->get(); 
			
			foreach ($folders as $folder) {
				$combined->push([
					'id' => $folder->id,
					'document_name' => '<a href="javascript:;" class="folder-btn" data-folder-id="' . $folder->id . '">'.$folder->name.'</a>',
					'type' => 'folder',
					'document_size' => null,
					'document_category' => null,
					'document_modified' => Carbon::parse($folder->updated_at)->format('Y-m-d H:i:s'),
					'document_type' => 'Folder',
					'contact_name' => null,
					'description' => null,
					'updated_at' => Carbon::parse($folder->updated_at)->format('Y-m-d H:i:s'),
					'action' => '<button class="btn btn-info folder-btn" data-folder-id="' . $folder->id . '">Open</button>'
				]);
			}
		}

		// Files shown in both views
		$files = Documents::query();
		
		if($root_document_folder_id && $root_document_folder_id==$folderId) {
			if ($viewMode !== 'folder')
			{
				
			}
			else {
				$files = $files->where('path_id', $folderId);
			}
		}
		else {
			$files = $files->where('path_id', $folderId);
		}
		
		if($lead_id>0) {
			$files = $files->where('intake_id', $lead_id);
		}
		
		$files = $files->get();
		
		foreach ($files as $file) {
			//$attach_url = route('admin.documents.serve', $file->id);
			$attach_url = asset('uploads/'.$file->document_path.'/'.$file->document_name);
			$contact = @$file->intake_value->contact ?? null;
			$contactName = $contact ? ($contact->display_name ?? trim("{$contact->first_name} {$contact->last_name}")) : '';

			$combined->push([
				'id' => $file->id,
				'document_name' => $file->document_name,
				'type' => 'file',
				'document_size' => $file->document_size,
				'document_category' => @$file->document_category_value->title ?? '',
				'document_modified' => Carbon::parse($file->updated_at)->format('Y-m-d H:i:s'),
				'document_type' => $file->document_type,
				'contact_name' => $contactName,
				'description' => $file->description,
				'updated_at' => Carbon::parse($file->updated_at)->format('Y-m-d H:i:s'),
				'action' => '<a href="' . $attach_url . '" class="btn btn-primary" target="_blank">View</a>'
			]);
		}

		return DataTables::of($combined)->rawColumns(['action', 'document_name'])->make(true);
	}	
	
	/*
	*
	* Function to Fetch Document Esign List.
	*
	*/	
    public function leadDocEsignList(Request $request)
    {
		abort_if(Gate::denies('intake_documents_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = $request->get('lead_id');
		$document_category = $request->get('document_category');
		if($request->ajax()) {
			$data = ESignDocuments::with(['case_type','created_by_name']);
			
			return DataTables::of($data)
				->editColumn('document_name', function ($row) {
					return @$row->document_name ?? '';
				})
				->addColumn('case_type', function ($row) {
					$case_type_title = $row->case_type->title ?? '';
					return $case_type_title.', Social Security Disability, Unassigned';
				})
				->addColumn('uploaded_at', function ($row) {
					$uploaded_at = Carbon::parse($row->created_at)->format('Y-m-d H:i:s');
					return $uploaded_at;
				})
				->addColumn('updated_at', function ($row) {
					$updated_at = Carbon::parse($row->updated_at)->format('Y-m-d H:i:s');
					return $updated_at;
				})
				->addColumn('created_by_name', function ($row) {
					return @$row->created_by_name->name ?? '';
				})
				->addColumn('document_action', function ($row) {
					$document_dir_path = @$row->document_path ?? '';
					$document_name = @$row->document_name ?? '';
					$attach_url = asset('uploads/'.$row->document_path.'/'.$document_name);
					$document_action='';
					$document_action = $document_action . '<a class="btn btn-send-lead-contract" title="Send">
						<i class="far fa-paper-plane"></i>
						<span style="font-size: 15px;">Send</span>
					</a>';
					$document_action = $document_action . '<a class="btn btn-sign-now" title="Sign Now">
						<i class="far fa-signature"></i>
						<span style="font-size: 15px;">Sign Now</span>
					</a>';
					$document_action = $document_action . '<a class="btn btn-view-contract" title="View Contract" target="_blank" href="'.$attach_url.'">
						<i class="far fa-eye"></i>
						<span style="font-size: 15px;">'.trans('documents.view').'</span>
					</a>';
					return $document_action;
				})
				->rawColumns(['document_action'])
				->make(true);
		}
    }
	
	/*
	*
	* Function to Fetch Document Esign Status List.
	*
	*/	
    public function leadDocEsignStatusList(Request $request)
    {
		abort_if(Gate::denies('intake_documents_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = $request->get('lead_id');
		$document_category = $request->get('document_category');
		if($request->ajax()) {
			$data = ESignDocumentStatus::with(['signers']);
			
			return DataTables::of($data)
				->addColumn('signers', function ($row) {
					return '
						<div class="justify-content-left align-items-center">
							<div class="">Name: '.$row->signers->name.'</div>
							<div class="">Email: '.$row->signers->email.'</div>
							<div class="">Order Number: '.$row->order_no.'</div>
							<div class="">Status: '.$row->signed_status.'</div>
						</div>';
				})
				->editColumn('envelope_id', function ($row) {
					return @$row->envelope_id ?? '';
				})
				->addColumn('sent_time', function ($row) {
					return Carbon::parse($row->created_at)->format('Y-m-d H:i:s');
				})
				->editColumn('template_name', function ($row) {
					return @$row->template_name ?? '';
				})
				->editColumn('envelope_status', function ($row) {
					return @$row->envelope_status ?? '';
				})
				->rawColumns(['signers'])
				->make(true);
		}
    }
	
	/*
	*
	* Function to Get Senders of Esign Doc.
	*
	*/	
    public function GetSenders(Request $request)
    {
		abort_if(Gate::denies('intake_documents_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = $request->lead_id;
		if($request->ajax()) {
			
			$senders_list = [
					["id"=>-1, "title" => "intake@clausondisability.com | E-Sign Default Sender"],
					["id"=>0, "title" => "Sumit.sinha@lmsummary.services | Non-Synced"]
				];
			
			if(isset($lead_id) && $lead_id>0) {
				
			}
			else {
				
			}			
			if($senders_list) {
				//$data = $senders_list->toArray();
				$data = $senders_list;
				return response()->json([
					'status' => 'success',
					'message' => 'Senders List',
					'data' => $data
				]);
			}
			else {
				return response()->json([
					'status' => 'error',
					'message' => 'Senders List Not Found'
				]);
			}
		}
    }
	
	/*
	*
	* Function to Get Recipients of Esign Doc.
	*
	*/	
    public function GetRecipients(Request $request)
    {
		abort_if(Gate::denies('intake_documents_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = $request->lead_id;
		if($request->ajax()) {
			
			$recipients_list = [
				["Id" => 127, "OnOff" => true, "SigningOrder" => "", "Placeholder" => "Client",  "Hidden_SignerID" => "Client", "Role" => "CC", "Name" => "Roger Gibson", "Email" => "rogerleegibson@gmail.com", "Phone" => "+12702011238", "SMS" => true],
				["Id" => 128, "OnOff" => true, "SigningOrder" => "", "Placeholder" => "User",  "Hidden_SignerID" => "12", "Role" => "CC", "Name" => "Back Office", "Email" => "backoffice@clausondisability.com", "Phone" => "", "SMS" => true],
				["Id" => 129, "OnOff" => true, "SigningOrder" => "1", "Placeholder" => "Client",  "Hidden_SignerID" => "Client", "Role" => "Signer", "Name" => "Roger Gibson", "Email" => "rogerleegibson@gmail.com", "Phone" => "+12702011238", "SMS" => true]
			];
			
			if(isset($lead_id) && $lead_id>0) {
				
			}
			else {
				
			}			
			
			return DataTables::of($recipients_list)
				->addColumn('esign_index', function ($row) {
					$esign_index='';
					$esign_index = $esign_index . '<img src="'.asset('images/drag_icon.png').'" style="filter: invert(50%);"><input name="esign-recipient-hidden-signerid" type="hidden" value="'.$row['Hidden_SignerID'].'">';
					return $esign_index;
				})
				->editColumn('OnOff', function ($row) {
					$OnOff='';
					$OnOff = $OnOff . '<input name="esign-recipient-onoff" type="checkbox" ';
					if($row['OnOff']) { 
						$OnOff = $OnOff . 'checked="checked"';
					}
					$OnOff = $OnOff . ' title="Is this person part of the signature request?">';
					return $OnOff;
				})
				->editColumn('SMS', function ($row) {
					$SMS='';
					$SMS = $SMS . '<input name="esign-recipient-sms" type="checkbox" ';
					if($row['SMS']) { 
						$SMS = $SMS . 'checked="checked"';
					}
					$SMS = $SMS . ' >';
					return $SMS;
				})
				->rawColumns(['esign_index', 'OnOff', 'SMS'])
				->make(true);
				
		}
    }
	
	/*
	*
	* Function to Upload Document.
	*
	*/	
    public function leadDocumentUpload(Request $request)
	{
		abort_if(Gate::denies('intake_documents_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

		$validator = \Validator::make($request->all(), [
			'document_file' => 'required|file|mimes:jpg,png,pdf,docx|max:2048',
			'document_category_id' => 'required'
		]);

		if ($validator->fails()) {
			return response()->json([
				'status' => 'validation_error',
				'message' => 'Validation Failed',
				'errors' => $validator->errors(),
			]);
		}

		if (!$request->ajax() || empty($request->lead_id)) {
			return response()->json(['status' => 'error', 'message' => 'Empty Lead/Case Id']);
		}
		
		$docUploadObj = new \App\Http\Controllers\Admin\DocumentUploadController();
		$docUploadResponse = $docUploadObj->documentUpload($request);
		$docUplResp = $docUploadResponse->getData();
		
		return response()->json([
			'status' => $docUplResp->status,
			'message' => $docUplResp->message
		]);
	}
	
}