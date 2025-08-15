<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Contact\StoreRequest;
use App\Http\Requests\Contact\EditRequest;
use App\Http\Requests\Contact\UpdateRequest;
use App\Http\Requests\Contact\DeleteRequest;
use App\Models\Contact;
use App\Models\ContactType;
use App\Models\IntakeContact;
use App\Models\Address;
use App\Models\ContactAddress;
use App\Models\Intake;
use App\Models\Language;
use App\Models\ContactPrefixes;
use App\Models\ContactMaritalStatus;
use App\Models\Activity;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Gate;
use DB;

class ContactController extends Controller
{
	/*
	*
	* Display a listing of the Contact table records.
	*
	*/	 
	public function index(Request $request)
    {	
		abort_if(Gate::denies('contact_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$contact_type_list = ContactType::distinct()->pluck('title','id');
		$languages = Language::distinct()->pluck('name','id');
		$prefix_list = ContactPrefixes::distinct()->pluck('title','id');
		$marital_status_list = ContactMaritalStatus::distinct()->pluck('title','id');
		
		return view('admin.contacts.index', ['contact_type_list'=>$contact_type_list, 'languages'=>$languages, 'prefix_list'=>$prefix_list, 'marital_status_list'=>$marital_status_list]);
    }
	
	/*
	*
	* Function to show from to get form inputs for New Contact.
	*
	*/	
	public function create()
    {		
		abort_if(Gate::denies('contact_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }
	
	/*
	*
	* Function to save new Contact records in a table.
	*
	*/
	public function store(StoreRequest $request)
	{
		$contact_data = $this->filterContactFields($request);

		$contact = Contact::create($contact_data);
		
		if($request->has('contact_address_ids')) {
			if(!empty($request->contact_address_ids))
			{
				foreach ($request->contact_address_ids as $address_id) {
					ContactAddress::firstOrCreate(['contact_id' => $contact->id, 'address_id' => $address_id]);
				}
			}
		}

		Activity::log(
			'contact',
			'create',
			"New Contact has been created with id - {$contact->id}",
			[
				'details' => $contact,
				'intake_id' => null
			]
		);

		return response()->json(['status' => 'success', 'message' => 'Contact created successfully.']);
	}
	
	/*
	*
	* Function to show Contact table records in details.
	*
	*/
	public function show(Request $request, $id)
    {
		abort_if(Gate::denies('contact_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }
	
	/*
	*
	* Function to edit Contact table records.
	*
	*/
	public function edit(EditRequest $request, $id)
    {	
		abort_if(Gate::denies('contact_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }
	
	/*
	*
	* Function to update Contact table records.
	*
	*/
	public function update(UpdateRequest $request, $id)
    {
		$filterInputData = $request->all();
		
		$contact = Contact::findOrFail($id);
		
		$old_data = [];
		if($contact)
		{
			$old_data = $contact->toArray();
			$contact->update($filterInputData);
		}	
		
		// Log the activity
		Activity::log(
			'contact',     
			'update',      
			"Contact Id - {$id} has been updated", 
			[
				'details' => [
								'old' => $old_data,
								'new' => $filterInputData
							 ],
				'intake_id' => null
			]                  			
		);
		
		return response()->json(['message' => 'Contact updated successfully.']);
    }
	
	/*
	*
	* Function to delete Contact table records.
	*
	*/
	public function destroy(DeleteRequest $request, $id)
	{	
		$contact = Contact::findOrFail($id);
				
		if($contact)
		{
			$contact->delete();
		
			// Log the activity
			Activity::log(
				'contact', 
				'delete',      
				"Contact Id - {$contact->id} has been deleted", 
				[
					'details' => $contact,
					'intake_id' => null
				]      
			);
		}

		return response()->json(['message' => 'Contact deleted successfully.']);
	}
	
	/*
	*
	* Function to update Contact Details with Ajax in a table.
	*
	*/
	public function updateContactDetails(Request $request)
	{
		abort_if(Gate::denies('contact_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		if (!$request->ajax()) {
			return response()->json([
				'status' => 'error',
				'message' => 'Invalid request type'
			], 400);
		}
		
		$contactDetails = Contact::find($request->contact_id);

		if (!$contactDetails) {
			return response()->json([
				'status' => 'error',
				'message' => 'Contact not found',
			]);
		}

		$oldData = $contactDetails->toArray();
        
		$updateData = $this->filterContactFields($request);

		// Ensure required fields are set manually or via defaults
		$updateData['intake_id'] = $contactDetails->intake_id;
		$updateData['firm_status'] = '1';

		$contactDetails->update($updateData);
		
		if($request->has('contact_address_ids')) {
			if(!empty($request->contact_address_ids))
			{
				foreach ($request->contact_address_ids as $address_id) {
					ContactAddress::firstOrCreate(['contact_id' => $contactDetails->id, 'address_id' => $address_id]);
				}
			}
		}

		Activity::log(
			'contact',
			'update',
			"Contact Details Id - {$contactDetails->id} has been updated",
			[
				'details' => [
								'old' => $oldData,
								'new' => $updateData
							 ],
				'intake_id' => null
			]
		);

		return response()->json([
			'status' => 'success',
			'message' => 'Contact updated successfully',
		]);
	}
	
	/*
	*
	* Function to Fetch All Contact List.
	*
	*/	
    public function contactList(Request $request)
    {
		abort_if(Gate::denies('contact_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = $request->get('lead_id');
		$contact_search = $request->get('contact_search');
		$contact_type = $request->get('contact_type');
		if($request->ajax()) {
			$data = Contact::query();
			if(!empty($contact_type)) {
				$data = $data->where('type',$contact_type);
			}
			if(!empty($contact_search)) {				
				$data = $data->where(function ($query) use ($contact_search) {
					$query->where('display_name','like','%'.$contact_search.'%')
						  ->orWhere('first_name','like','%'.$contact_search.'%')
                          ->orWhere('last_name','like','%'.$contact_search.'%')
                          ->orWhere('email','like','%'.$contact_search.'%')
                          ->orWhere('phone','like','%'.$contact_search.'%');
				});
			}
			return DataTables::of($data)
				->addIndexColumn()
				->addColumn('checkbox', function ($row) {
					return '<input type="checkbox" class="user-checkbox"value="'.$row->id.'">';
				})
				->addColumn('name', function ($row) {
					$name = $row->display_name ? $row->display_name : trim($row->first_name .' '.$row->last_name);
					if(isset($lead_id) && $lead_id>0) {
						return '<a href="javascript:;" onclick="setContactDetails(\''.$row->id.'\');" >'.$name.'</a>';
					}
					else {
						return '<a href="javascript:;" onclick="getContactDetails(\''.$row->id.'\');" >'.$name.'</a>';
					}
				})
				->addColumn('contact_type', function ($row) {
					return $row->contact_type->title ? $row->contact_type->title : '';
				})
				->editColumn('created_at', function ($row) {
					return $row->created_at->format('Y-m-d H:i:s');
				})
				->addColumn('address', function ($row) {
					return '';
				})
				->addColumn('action', function($row){
					$btn = '';
					
					if(!Gate::denies('contact_show'))
					{
                    $btn = $btn . '<a href="javascript:;" class="show-btn btn btn-info btn-sm m-1 showPopupContactBtn" data-id="'.$row->id.'" ><i class="fa fa-eye ph-eye" aria-hidden="true"></i></a>';
					}
					
					if(!Gate::denies('contact_edit'))
					{
						$btn = $btn . '<a href="javascript:;" class="edit-btn btn btn-primary btn-sm m-1 editPopupContactBtn" data-id="'.$row->id.'" ><i class="fa fa-edit ph-pencil" aria-hidden="true"></i></a>';
					}
					
					if(!Gate::denies('contact_delete'))
					{
						$btn = $btn . '<a href="javascript:void(0);" data-id="'.$row->id.'" class="delete-btn btn btn-danger btn-sm m-1"><i class="fa fa-trash ph-trash" aria-hidden="true"></i></a>';
					}
					
                    return $btn;
                })
				->rawColumns(['checkbox','name','action'])
				->make(true);
		}
    }
	
	/*
	*
	* Function to get Contact Details.
	*
	*/	
    public function contactDetails(Request $request)
    {
		abort_if(Gate::denies('contact_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$contact_id = $request->id;
		if($request->ajax()) {
			$contact_details = Contact::findOrFail($contact_id);
			if($contact_details) {	
				$data = $contact_details->toArray();
				$name = $data['display_name'] ? $data['display_name'] : trim($data['first_name'] .' '.$data['last_name']);
				if($data){
					$data['name'] = $name;
				}
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
	* Function to Fetch Lead Related Contact List.
	*
	*/	
    public function leadRelatedContactList(Request $request)
    {
		abort_if(Gate::denies('contact_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = $request->get('lead_id');
		$contact_search = $request->get('contact_search');
		if($request->ajax()) {
			$data = IntakeContact::where('intake_id',$lead_id);
			/*if(!empty($contact_search)) {				
				$data = $data->where(function ($query) use ($contact_search) {
					$query->where('display_name','like','%'.$contact_search.'%')
						  ->orWhere('first_name','like','%'.$contact_search.'%')
                          ->orWhere('last_name','like','%'.$contact_search.'%')
                          ->orWhere('email','like','%'.$contact_search.'%')
                          ->orWhere('phone','like','%'.$contact_search.'%');
				});
			}*/
			return DataTables::of($data)
				->addColumn('name', function ($row) {
					$name = '';
					$contact_id = 0;
					if($row->contact_value) {
						$name = $row->contact_value->display_name ? $row->contact_value->display_name : trim($row->contact_value->first_name .' '.$row->contact_value->last_name);
						$contact_id = $row->contact_value->id ? $row->contact_value->id : 0;
					}
					return '<a href="javascript:;" class="context-icon" data-id="'.$row->id.'" data-contact_id="'.$contact_id.'" >'.$name.'</a>';
				})
				->addColumn('case_role', function ($row) {
					$case_role_html = '';
					if($row->intake_value->case_roles) {
						foreach($row->intake_value->case_roles as $case_roles)
						{
							if($case_roles->title) {
								$case_role = $case_roles->title ? $case_roles->title : '';
								$case_role_html = $case_role_html.'<a href="javascript:;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changeCaseRoleModal" >'.$case_role.'</a> ';
							}
						}
					}
					return $case_role_html;
				})
				->rawColumns(['name','case_role'])
				->make(true);
		}
    }
	
	/*
	*
	* Function to Add Address from related contact section.
	*
	*/
	public function addAddress(Request $request)
	{
		abort_if(Gate::denies('contact_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		// Only keep non-empty inputs
		$address_data = array_filter($request->only([
			'address_type', 'address_1', 'address_2', 'city', 'country', 'zip', 'state_id', 'country_id'
		]));

		$address_data['is_primary'] = ($request->input('is_primary') === 'on') ? "1" : "0";

		if ($request->ajax()) {
			if (!empty($address_data)) {
				$address = Address::create($address_data);

				if ($address) {
					
					if($request->has('contact_id')) {
						if($request->contact_id > 0) {
							ContactAddress::firstOrCreate(['contact_id' => $request->contact_id, 'address_id' => $address->id]);
						}
					}
					
					return response()->json([
						'status' => 'success',
						'message' => 'Address Added Successfully',
						'data' => ['address_id' => $address->id]
					]);
				}

				return response()->json([
					'status' => 'error',
					'message' => 'Address Not Added'
				]);
			}

			return response()->json([
				'status' => 'error',
				'message' => 'Required field is empty'
			]);
		}
	}
	
	/*
	*
	* Function to Fetch All Contact Address List.
	*
	*/	
    public function contactAddressList(Request $request)
    {
		abort_if(Gate::denies('contact_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		if($request->ajax()) {
			//$data = ($request->contact_id && $request->contact_id>0 ? Address::query() : Address::query());
			
			if($request->has('contact_id') && $request->contact_id>0) {
				$data = Address::select('address.*')
				->join('contact_address', 'address.id', '=', 'contact_address.address_id')
				->where('contact_address.contact_id', $request->contact_id);
			}
			else {
				$data = Address::select('address.*')
				->leftjoin('contact_address', 'address.id', '=', 'contact_address.address_id')
				->whereNull('contact_address.contact_id');
			}
			
			return DataTables::of($data)
				->addColumn('address', function ($row) {
					$address_1 = $row->address_1 ? $row->address_1 : '';
					$address_2 = $row->address_2 ? $row->address_2 : '';
					return '<input type="hidden" class="contact-address-ids" name="contact_address_ids[]" value="' . $row->id . '" data-id="'.$row->id.'" /><span>'. trim($address_1.' '.$address_2) .'</span>';
				})
				->addColumn('type', function ($row) {
					return @$row->address_type_value->title ? $row->address_type_value->title : '';
				})
				->rawColumns(['address'])
				->make(true);
		}
    }
	
	/*
	*
	* Function to Add Lead Contact in related contact section.
	*
	*/
	public function addLeadContact(Request $request)
    {		
		abort_if(Gate::denies('contact_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		
		$lead_id = $request->lead_id;
		$contact_id = $request->contact_id;
		if($request->ajax()) {
			$contact_data = Contact::find($contact_id);
			$lead_data = Intake::find($lead_id);
			if($contact_data)
			{
				if($contact_data)
				{
					$intake_contacts = IntakeContact::where('intake_id',$lead_id)->get();
					if($intake_contacts)
					{
						IntakeContact::where('intake_id',$lead_id)->delete();
					}
					IntakeContact::create(['intake_id'=>$lead_id,'contact_id'=>$contact_id]);
					
					$lead_data->contact_id = $contact_id;
					$lead_data->save();
					
					return response()->json([
						'status' => 'success',
						'message' => 'Address Added Successfully',
						'data' => []
					]);
				}
				else {
					return response()->json([
						'status' => 'success',
						'message' => 'Lead Details Not Found'
					]);
				}				
			}
			else {
				return response()->json([
					'status' => 'error',
					'message' => 'Contact Details not Found'
				]);
			}			
		}
    }
	
	private function filterContactFields(Request $request)
	{
		$fields = [
			'contact_nature' => 'nature',
			'contact_type' => 'type',
			'contact_prefix' => 'prefix',
			'contact_suffix' => 'suffix',
			'contact_gender' => 'gender',
			'contact_email' => 'email',
			'contact_preference' => 'contact_preference',
			'contact_phone' => 'phone',
			'contact_whentocontact' => 'whentocontact',
			'contact_language' => 'language',
			'contact_alias' => 'alias',
			'contact_marital_status' => 'marital_status',
			'contact_company_name' => 'company_name',
			'contact_job_title' => 'job_title',
			'contact_ssn' => 'ssn',
			'contact_work_phone' => 'work_phone',
			'contact_home_phone' => 'home_phone',
			'contact_fax' => 'fax',
			'contact_secondary_email' => 'secondary_email',
			'contact_drivers_license' => 'drivers_license',
			'contact_dob' => 'dob',
			'contact_dodeath' => 'dodeath',
			'contact_dobankruptcy' => 'dobankruptcy',
			'contact_notes' => 'notes',
		];

		$contact_data = [];

		foreach ($fields as $input => $field) {
			if ($request->filled($input)) {
				$contact_data[$field] = $request->input($input);
			}
		}

		// Handle name and display name logic
		$display_name = '';
		$name_parts = [
			'contact_first_name' => 'first_name',
			'contact_middle_name' => 'middle_name',
			'contact_last_name' => 'last_name',
		];

		foreach ($name_parts as $input => $field) {
			if ($request->filled($input)) {
				$value = $request->input($input);
				$contact_data[$field] = $value;
				$display_name .= ($display_name ? ' ' : '') . $value;
			}
		}

		if (!empty($display_name)) {
			$contact_data['display_name'] = $display_name;
		}
		
		return $contact_data;
	}
}