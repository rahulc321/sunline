<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Helpers\GeneralFunctions;
use App\Models\Documents;
use App\Models\DocumentCategory;
use App\Models\DocumentFolder;
use App\Models\DocumentPath;
use App\Models\Intake;
use App\Models\Activity;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Auth;
use Gate;
use DB;

class DocumentUploadController extends Controller
{	
	/*
	*
	* Function to Upload Document.
	*
	*/	
    public function documentUpload(Request $request)
	{
		abort_if(Gate::denies('intake_documents_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		if((strtolower($request->page_section) === 'notes')) {
			$validator = \Validator::make($request->all(), [
				'notes_attachment' => 'required|file|mimes:jpg,png,pdf,docx|max:2048',
				'document_category_id' => 'nullable|integer'
			]);
		}
		else {
			$validator = \Validator::make($request->all(), [
				'document_file' => 'required|file|mimes:jpg,png,pdf,docx|max:2048',
				'document_category_id' => 'required'
			]);
		}

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

		$lead = Intake::with('contact')->find($request->lead_id);
		$contact = $lead?->contact;

		$current_folder_name = $contact ? GeneralFunctions::generateNames(trim($contact->display_name)) : null;

		$this->createLeadDocDefaultDir($lead->id, $current_folder_name);

		$folderPathData = $this->buildFolderPath($request, $current_folder_name);
		$folderPath = $folderPathData['path'];
		$folderDirArr = $folderPathData['dirArr'];
		$folderId = $folderPathData['folderId'];

		$pathId = $this->createFolderStructure($folderDirArr, $lead->id);

		// Handle file upload
		$document_description = ''; 
		if((strtolower($request->page_section) === 'notes')) {
			$document_description = $request->notes; 
			$file = $request->file('notes_attachment');
		}
		else {
			$document_description = $request->document_description; 
			$file = $request->file('document_file');
		}
		
		$documentInfo = $this->storeFile($file, $folderPath);
		
		$lead_documents = Documents::create([
			'intake_id' => $request->lead_id,
			'document_category_id' => $request->document_category_id ?? null,
			'document_folder_id' => $folderId ?? null,
			'path_id' => $pathId,
			'document_title' => $documentInfo['title'],
			'document_name' => $documentInfo['filename'],
			'document_path' => $documentInfo['path'],
			'document_size' => $documentInfo['size'],
			'document_type' => $documentInfo['type'],
			'description' => $document_description 
		]);

		Activity::log('lead_documents', 'create', "Lead Documents uploaded with id - {$lead_documents->id}", [
			'details' => $lead_documents,
			'intake_id' => $request->lead_id
		]);

		return response()->json([
			'status' => 'success',
			'message' => 'Documents uploaded successfully',
			'data' => [
				'document_name' => $documentInfo['filename'],
				'document_path' => $documentInfo['path'],
			]
		]);
	}
	
	/*
	*
	* Function to Get Document Upload/Save Dir Path For Adding Document to Print Queue.
	*
	*/	
    public function docPrintQueueDirPath(Request $request)
	{
		abort_if(Gate::denies('export_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		if (!$request->ajax() || empty($request->lead_id)) {
			return response()->json(['status' => 'error', 'message' => 'Empty Lead/Case Id']);
		}
		
		$lead = Intake::with('contact')->find($request->lead_id);
		$contact = $lead?->contact;

		$current_folder_name = $contact ? GeneralFunctions::generateNames(trim($contact->display_name)) : null;

		$this->createLeadDocDefaultDir($lead->id, $current_folder_name);

		$folderPathData = $this->buildFolderPath($request, $current_folder_name);
		$folderPath = $folderPathData['path'];
		$folderDirArr = $folderPathData['dirArr'];
		$folderId = $folderPathData['folderId'];

		$pathId = $this->createFolderStructure($folderDirArr, $lead->id);
		
		return response()->json([
			'status' => 'success',
			'message' => 'Document Path Info',
			'data' => [
				'path_id' => $pathId,
				'folder_id' => $folderId,
				'folder_path' => $folderPath,
			]
		]);
	}
	
	/*
	*
	* Function to get Rename Document File Name.
	*
	*/
	public function renameDocument(Request $request)
	{
		abort_if(Gate::denies('intake_documents_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$request->validate([
			'id' => 'required|exists:documents,id',
			'new_name' => 'required|string'
		]);

		$document = Documents::findOrFail($request->id);
		
		$uploadPath = public_path('uploads/' . $document->document_path);
		$oldPath = $uploadPath.'/'. $document->document_name;
		$directory = dirname($oldPath);
		$extension = pathinfo($oldPath, PATHINFO_EXTENSION);
		$baseName = GeneralFunctions::generateNames(pathinfo($request->new_name, PATHINFO_FILENAME));
		$newFilename = $baseName . '.' . $extension;
		$newPath = $directory . '/' . $newFilename;
		$counter = 1;

		//Check for file name conflict and append number if needed
		while(File::exists($uploadPath.'/'. $newFilename)) {
			$newFilename = $baseName . $counter . '.' . $extension;
			$newPath = $directory . '/' . $newFilename;
			$counter++;
		}
		
		// Rename file physically
		if (File::exists($oldPath)) {
			File::move($oldPath, $newPath);
		} else {
			return response()->json(['success' => false, 'message' => 'File not found.']);
		}

		// Update DB
		$document->document_name = $newFilename;
		$document->save();

		return response()->json(['success' => true, 'message' => 'File renamed successfully.']);
	}
	
	/*
	*
	* Function to get Folder Id Details By Category Id.
	*
	*/
	private function getFolderIdByDocCategoryId($doc_cat_id) {
		$folder_id = null;
		if(!$doc_cat_id) {
			return $folder_id;
		}
		$cat_title = '';
		$catDetails = DocumentCategory::where('id',$doc_cat_id)->select('title')->first();
		if($catDetails) {
			$cat_title = $catDetails->title;
			$folderDetails = DocumentFolder::where('folder_name',$cat_title)->select('folder_name', 'id')->first();
			if($folderDetails) {
				return $folderDetails->id;
			}
		}
		return $folder_id;
		
	}
	
	/*
	*
	* Function to get Folder/SubFolder DIR Path.
	*
	*/
	private function buildFolderPath($request, $currentFolderName)
	{
		$folderArr = ['Documents'];
		$folderPath = 'Documents/';

		if ($currentFolderName) {
			$folderPath .= $currentFolderName . '/';
			$folderArr[] = $currentFolderName;

			$leadFolder = $request->lead_id . '-' . $currentFolderName;
			$folderPath .= $leadFolder . '/';
			$folderArr[] = $leadFolder;
		}

		$folderId = null;
		$folderName = '';

		if ($request->document_folder > 0) {
			$folderId = $request->document_folder;
		} elseif (strtolower($request->page_section) === 'notes') {
			$folderId = 7;	
		} elseif (strtolower($request->page_section) === 'tasks') {
			$folderId = 8;			
		} else {
			$folderId = $this->getFolderIdByDocCategoryId($request->document_category_id);
		}

		if ($folderId) {
			$folderName = GeneralFunctions::generateNames(
				DocumentFolder::where('id', $folderId)->value('folder_name')
			);
			$folderPath .= $folderName . '/';
			$folderArr[] = $folderName;
		}

		return ['path' => $folderPath, 'dirArr' => $folderArr, 'folderId' => $folderId];
	}
	
	private function createFolderStructure(array $folderArr, $intake_id=null)
	{
		$parentId = null;
		foreach ($folderArr as $folderName) {
			$existing = DocumentPath::where('name', $folderName)
				->where('parent_id', $parentId)
				->first();

			$parentId = $existing?->id ?? DocumentPath::create([
				'name' => $folderName,
				'parent_id' => $parentId,
				'intake_id' => $intake_id,
			])->id;
		}
		return $parentId;
	}
	
	private function storeFile($file, $folderPath)
	{
		$uploadPath = public_path('uploads/' . $folderPath);
		File::ensureDirectoryExists($uploadPath, 0755, true);

		$originalName = $file->getClientOriginalName();
		$filenameParts = explode('_', pathinfo($originalName, PATHINFO_FILENAME));
		$title = implode('-', $filenameParts);
		$size = $file->getSize();
		$extension = $file->getClientOriginalExtension() ?: $file->extension();
		$filename = $title . time() . '.' . $extension;

		$file->move($uploadPath, $filename);

		return [
			'filename' => $filename,
			'title' => $title,
			'path' => rtrim($folderPath, '/'),
			'size' => $size,
			'type' => $extension
		];
	}
	
	/*
	*
	* Function to Create Document Default Directory/Sub Directory For Lead.
	*
	*/
	private function createLeadDocDefaultDir($intake_id = 0, $dirName = null)
	{	
		if(!empty($intake_id) && !empty($dirName))
		{
			$dirName = trim($dirName);
			$dirName = GeneralFunctions::generateNames($dirName);
		
			$defaultFolder = DocumentFolder::where('is_default', 1)
					->orderBy('order', 'ASC')
					->pluck('folder_name')
					->toArray();
			$folderParentTree = [
									'Documents',
									$dirName,
									$intake_id.'-'.$dirName
								];
					
			if($defaultFolder) {
				foreach($defaultFolder as $folderName)
					{
						$folderTree = $folderParentTree;
						$folderTree[] = $folderName;
						
						$parentId = null; 
						$currentPath = '';
						foreach ($folderTree as $curDirName) {
							$currentPath = trim($currentPath . '/' . $curDirName, '/');
							$existingFolder = DocumentPath::where('name', $curDirName)
												->where('parent_id', $parentId)
												->first();

							if ($existingFolder) {
								$parentId = $existingFolder->id;
							} else {
								$newFolder = DocumentPath::create([
									'name' => $curDirName,
									'parent_id' => $parentId,
									'intake_id' => $intake_id,
								]);

								$parentId = $newFolder->id; // Set as parent for next folder
							}
						}
					}
			}	
		}
	}
	
	/*
	*
	* Function to view Files from Storage.
	*
	*/
	public function serveFile($id)
	{
		abort_if(Gate::denies('intake_documents_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$file = Documents::findOrFail($id);
		
		/*
		$filePath = 'public/files/' . $file->document_path;
        if (!Storage::exists($filePath)) {
            abort(404, 'File not found.');
        }		
		return Storage::response($filePath, $file->document_name);
		*/
		
		$filePath = 'uploads/' . $file->document_path . '/' .$file->document_name;
        if (!file_exists(public_path($filePath))) {
            abort(404, 'File not found.');
        }	
		$mime = mime_content_type(public_path($filePath));		
		return response()->file(public_path($filePath), [
				'Content-Type' => $mime,
				'Content-Disposition' => 'inline; filename="' . $file->document_name . '"',
		]);
	}
	
	/*
	*
	* Function to Download Files from Storage.
	*
	*/
	public function downloadFile($id)
	{
		abort_if(Gate::denies('intake_documents_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$file = Documents::findOrFail($id);

		/*
		$filePath = 'public/files/' . $file->document_path;
		if (!Storage::exists($filePath)) {
            abort(404, 'File not found.');
        }		
		return Storage::download($filePath, $file->file_name);
		*/
		
		$filePath = 'uploads/' . $file->document_path . '/' .$file->document_name;
        if (!file_exists(public_path($filePath))) {
            abort(404, 'File not found.');
        }			
		return response()->download(public_path($filePath), $file->document_name);
	}
}