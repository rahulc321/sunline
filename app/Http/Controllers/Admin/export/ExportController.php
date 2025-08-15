<?php

namespace App\Http\Controllers\Admin\Export;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\FormExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

use App\Models\Intake;
use App\Models\IntakeValues;
use App\Models\Contact;
use App\Models\AddressType;
use App\Models\IntakeContact;
use App\Models\LeadKeyDate;
use App\Models\CaseRole;
use App\Models\LeadCaseRole;
use App\Models\LeadNotes;
use App\Models\FormQuestionAnswer;
use App\Models\LeadCallOutcome;
use App\Models\ContactType;
use App\Models\Language;
use App\Models\ContactPrefixes;
use App\Models\ContactMaritalStatus;
use App\Models\NotesCategory;
use App\Models\TaskType;
use App\Models\TasksCategory;
use App\Models\LeadCommunicationEmail;
use App\Models\LeadCommunicationTexts;
use App\Models\DocumentCategory;
use App\Models\Documents;
use App\Models\DocumentPrintQueue;
use App\Models\Activity;

use App\Helpers\GeneralFunctions;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Auth;
use Gate;
use DB;

class ExportController extends Controller
{
	/*
	*
	* Function to Export Data in PDF.
	*
	*/	
    public function exportData(Request $request)
    {
		abort_if(Gate::denies('export_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$data = $request->all();
		
		$type = (isset($data['type']) && $data['type']!='')?$data['type']:'';
		$id = (isset($data['id']) && $data['id']!='')?$data['id']:'';
		$print_existing_data = (isset($data['print_existing_data']) && $data['print_existing_data']==1)?'1':'0';
		$print_format = (isset($data['print_format']) && $data['print_format']!='')?$data['print_format']:'';
		$is_queue = (isset($data['is_queue']) && $data['is_queue']==1)?'1':'0';
		
		$request_data = [];
		
		if($print_existing_data==1)
		{
			$intake_values = IntakeValues::get()->groupBy(function($intake_values) {
				return $intake_values->type;
			});
			
			$case_role = CaseRole::distinct()->pluck('title','id');
			$intake_values['case_role'] = $case_role;
			
			$lead_call_outcome = LeadCallOutcome::distinct()->pluck('title','id');
			$intake_values['lead_call_outcome'] = $lead_call_outcome;
			
			$lead_data = Intake::with('case_roles')->with('question_answer')->find($id);
			
			$contact_data = Contact::find($lead_data->contact_id);
			
			$address_type = AddressType::distinct()->pluck('title','id');
			$intake_values['address_type'] = $address_type;
			
			$contact_type_list = ContactType::distinct()->pluck('title','id');
			$languages = Language::distinct()->pluck('name','id');
			$prefix_list = ContactPrefixes::distinct()->pluck('title','id');
			$marital_status_list = ContactMaritalStatus::distinct()->pluck('title','id');
			$notes_category_list = NotesCategory::distinct()->pluck('title','id');
			$tasks_type_list = TaskType::distinct()->pluck('title','id');
			$tasks_category_list = TasksCategory::distinct()->pluck('title','id');
			
			$request_data = ['lead_data'=>$lead_data, 'intake_values'=> $intake_values, 'contact_data'=> $contact_data, 'contact_type_list'=>$contact_type_list, 'languages'=>$languages, 'prefix_list'=>$prefix_list, 'marital_status_list'=>$marital_status_list, 'notes_category_list'=>$notes_category_list, 'tasks_type_list'=>$tasks_type_list, 'tasks_category_list'=>$tasks_category_list];
		}
		
		if($type=='form')
		{
			if($print_format=='pdf')
			{
				if(isset($is_queue) && $is_queue=='1') {
					$pdf = Pdf::loadView('admin.export.pdf.form-data',$request_data);
					$this->saveDocumentsPrintQueue($request, ['data' => $data, 'request_data' => $request_data]);
					return response()->json([
						'status' => 'success', 
						'type' => 'pdf', 	
						'pdf' => 'data:application/pdf;base64,'.base64_encode($pdf->output()),
					]);
				}	
				else {
					$pdf = Pdf::loadView('admin.export.pdf.form-data',$request_data);
					return response()->json([
						'status' => 'success', 
						'type' => 'pdf', 
						'pdf' => base64_encode($pdf->output()), // or send temp file url
						'filename' => $lead_data->id.'-Legal CRM Intake Format Default.pdf'	
					]);
				}
			}
			else if($print_format=='excel')
			{
				return response()->json([
					'status' => 'success', 
					'type' => 'excel', 
					'excel' => '', // or send temp file url
					'filename' => 'form-data.pdf'	
				]);
			}
			else if($print_format=='word')
			{
				return response()->json([
					'status' => 'success', 
					'type' => 'word', 
					'word' => '', // or send temp file url
					'filename' => 'form-data.pdf'	
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
		else if($type=='notes')
		{
			if($print_format=='pdf')
			{ 
				$data = LeadNotes::where('intake_id',$id);
				
				$yajra_datatable = DataTables::of($data)
				->addColumn('user_name', function ($row) {
					$user_name='';
					if($row->user) {
						$user_name = $row->user->name ? $row->user->name : '';
					}
					return $user_name;
				})
				->addColumn('category', function ($row) {
					$category='';
					if($row->category_value) {
						$category = $row->category_value->title ? $row->category_value->title : '';
					}
					return $category;
				})
				->editColumn('notes_date', function ($row) {
					return $row->created_at ? Carbon::parse($row->created_at)->format('Y-m-d') : '';
				})
				->toArray();
				
				$notes_list = [];
				
				if(isset($yajra_datatable['data']) && !empty($yajra_datatable['data'])) {
					$notes_list = $yajra_datatable['data'];
				}
				
				if(isset($notes_list) && !empty($notes_list))
				{
					$pdf = Pdf::loadView('admin.export.pdf.notes-data',['notes_list'=>$notes_list]);
					return response()->json([
						'status' => 'success', 
						'type' => 'pdf', 
						'pdf' => base64_encode($pdf->output()), // or send temp file url
						'filename' => 'notes-data.pdf'	
					]);
				}
				else 
				{
					return response()->json([
						'status' => 'error', 	
						'message' => 'No Notes Found', 	
					]);
				}
			}
			else 
			{
				return response()->json([
					'status' => 'error', 	
					'message' => 'Invalid Print Format', 	
				]);
			}
		}
		else if($type=='communications')
		{
			if($print_format=='pdf')
			{ 
				$data = LeadCommunicationEmail::where('intake_id',$id);
				
				$yajra_datatable = DataTables::of($data)
				->editColumn('communications_date', function ($row) {
					return $row->created_at ? Carbon::parse($row->created_at)->format('Y-m-d') : '';
				})
				->editColumn('status', function ($row) {
					$status='';
					if($row->email_status) {
						$status = $row->email_status->title ? $row->email_status->title : '';
					}
					return $status;
				})
				->editColumn('campaign_type', function ($row) {
					$campaign_type='';
					if($row->campaign_type) {
						$campaign_type = $row->campaign_type->title ? $row->campaign_type->title : '';
					}
					return $campaign_type;
				})
				->toArray();
				
				$communications_list = [];
				
				if(isset($yajra_datatable['data']) && !empty($yajra_datatable['data'])) {
					$communications_list = $yajra_datatable['data'];
				}
				
				if(isset($communications_list) && !empty($communications_list))
				{
					$pdf = Pdf::loadView('admin.export.pdf.communications-data',['communications_list'=>$communications_list]);
					return response()->json([
						'status' => 'success', 
						'type' => 'pdf', 
						'pdf' => base64_encode($pdf->output()), // or send temp file url
						'filename' => 'communications-data.pdf'	
					]);
				}
				else 
				{
					return response()->json([
						'status' => 'error', 	
						'message' => 'No Notes Found', 	
					]);
				}
			}
			else 
			{
				return response()->json([
					'status' => 'error', 	
					'message' => 'Invalid Print Format', 	
				]);
			}
		}
		else 
		{
			return response()->json([
				'status' => 'error', 	
				'message' => 'Invalid Data', 	
			]);
		}
    }
	
	/*
	*
	* Function to Export Data in Excel.
	*
	*/	
    public function exportToExcel(Request $request)
    {
		abort_if(Gate::denies('export_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$formData = FormQuestionAnswer::select('intake_id', 'question_id', 'answer')->get()->toArray();
		
		return Excel::download(new FormExport($formData), 'form-data.xlsx');
    }
	
	/*
	*
	* Function to Export Data in Word.
	*
	*/	
    public function exportToWord(Request $request)
    {
		abort_if(Gate::denies('export_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$data = $request->all();
		$phpWord = new PhpWord();
		$section = $phpWord->addSection();
		foreach($data as $key => $value) {
			$section->addText("$key:$value");
		}
		
		$fileName = 'form-data.docx';
		$temp_file = tempnam(sys_get_temp_dir(), $fileName);
		$writer = IOFactory::createWriter($phpWord, 'Word2007');
		$writer->save($temp_file);
		
		return response()->download($temp_file, fileName)->deleteFileAfterSend(true);
    }
	
	/*
	*
	* Function to save Documents For Print Queue Case.
	*
	*/	
    private function saveDocumentsPrintQueue(Request $request, $dataParams = [])
    {
		$data = $dataParams['data'] ?? [];
		$request_data = $dataParams['request_data'] ?? [];
		
		$type = $data['type'] ?? '';
		$lead_id = $data['id'] ?? '';
		$print_existing_data = (isset($data['print_existing_data']) && $data['print_existing_data']==1)?'1':'0';
		$print_format = $data['print_format'] ?? '';
		$is_queue = (isset($data['is_queue']) && $data['is_queue']==1)?'1':'0';
		
		$default_file_name = 'Lead Data Document';
		if($type == 'form') {
			$default_file_name = $lead_id.'-Legal CRM Intake Format Default';
		}
		$baseName = GeneralFunctions::generateNames($default_file_name);
		$extension = 'pdf';
		if(!empty($print_format)) {
			if($print_format == 'pdf') {
				$extension = 'pdf';
			}
		}
		$fileName = $baseName.'.'.$extension;
		$document_category_id = DocumentCategory::where('title', 'Intake')->value('id');					
		$request->merge(['lead_id' => $lead_id, 'document_category_id' => $document_category_id]);
		$docUploadObj = new \App\Http\Controllers\Admin\DocumentUploadController();
		$docUploadResponse = $docUploadObj->docPrintQueueDirPath($request);
		$docUplResp = $docUploadResponse->getData();
		$pathId = @$docUplResp->data->path_id ?? null;
		$folderId = @$docUplResp->data->folder_id ?? null;
		$folderPath = @$docUplResp->data->folder_path ?? null; /* This contains '/' at the end */
		$uploadPath = public_path('uploads/' . $folderPath);
		$fullPath = $uploadPath. $fileName;
		
		$counter = 1;
		//Check for file name conflict and append number if needed
		while(File::exists($uploadPath. $fileName)) {
			$fileName = $baseName . $counter . '.' . $extension;
			$fullPath = $uploadPath . $fileName;
			$counter++;
		}
		
		if($print_format == 'pdf') {
			$pdf = Pdf::loadView('admin.export.pdf.form-data',$request_data);
			$pdf->save($fullPath);
		}
		
		$size = File::size($fullPath);
		$filenameParts = explode('_', pathinfo($fileName, PATHINFO_FILENAME));
		$title = implode('-', $filenameParts);
		
		$documentInfo = [
			'filename' => $fileName,
			'title' => $title,
			'path' => rtrim($folderPath, '/'),
			'size' => $size,
			'type' => $extension
		];
		
		$lead_documents = Documents::create([
			'intake_id' => $lead_id,
			'document_category_id' => $document_category_id,
			'document_folder_id' => $folderId,
			'path_id' => $pathId,
			'document_title' => $documentInfo['title'],
			'document_name' => $documentInfo['filename'],
			'document_path' => $documentInfo['path'],
			'document_size' => $documentInfo['size'],
			'document_type' => $documentInfo['type'],
			'description' => null 
		]);
		
		DocumentPrintQueue::create([
			'document_id' => $lead_documents->id,
			'created_by' => auth()->user()->id
		]);

		Activity::log('lead_documents', 'create', "Lead Documents Added to Print Queue with id - {$lead_documents->id}", [
			'details' => $lead_documents,
			'intake_id' => $lead_id
		]);
		
	}
}