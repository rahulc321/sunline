<?php

namespace App\Helpers;

use App\Models\DocumentPath;

class GeneralFunctions
{	
	/*
	*
	* Sanitize username to create valid folder and file name.
	*
	* @param string $username
	* @return string
	*
	*/	 
	public static function generateNames(string $username): string
    {	
		// Replace all non-alphanumeric characters with underscore
		$sanitized = preg_replace('/[^A-Za-z0-9\- ]/', '_', $username);
		return $sanitized; 
    }
	
	/*
	*
	* Get Folder Name and Its Sub Folder IDs (children).
	*
	*/	
	public static function getFolderDetails($id, $type='id')
	{
		if($type=='name') {
			$folderDetails = DocumentPath::with('children:id,parent_id,name')->where('name',$id)->first();
			$id = $folderDetails->id ?? null;
		}	

		$folder = DocumentPath::with('children:id,parent_id,name')->find($id);

		if (!$folder) {
			return false;
		}
		
		return [
			'id' => $folder->id,
			'name' => $folder->name,
			'subfolders' => $folder->children->map(function ($child) {
				return [
					'id' => $child->id,
					'name' => $child->name
				];
			})->toArray()
		];
	}
	
	/*
	*
	* Traces the folder path array Root to Child.
	*
	*/	
	public static function getFolderPathArray($folderId)
    {
        $path = [];
        while ($folderId) {
            $folder = DocumentPath::find($folderId);
            if ($folder) {
                array_unshift($path, ['id'=>$folder->id, 'name'=>$folder->name]);
                $folderId = $folder->parent_id;
            } else {
                break;
            }
        }
        return $path;
    }
	

}	