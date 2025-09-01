<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fri;
use DB;
use App\User;
use App\Models\Lead;
use Auth;

class FriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
	{   
        error_reporting(0);
		$this->data['fris'] = Fri::get();

        $this->data['users'] = User::whereHas('roles', function ($query) {
			$query->where('title', 'User');
		})->get();


        $this->data['status'] = DB::table('statuses')->where('status', 1)->get();
        $this->data['priority'] = DB::table('priorities')->where('status',1)->get();
        $this->data['category'] = DB::table('categories')->where('status',1)->get();
        $this->data['leads'] = Lead::get();

        return view('admin.fri.index',$this->data);
	}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        # validate inputs
        $validated = $request->validate([
            // 'project'      => 'required|string|max:255',
            // 'client'       => 'required|string|max:255',
            'category'     => 'required|string|max:255',
            'priority'     => 'required|string|max:255',
            'due_date'     => 'required|date',
            'assigned_to'  => 'required|integer|exists:users,id',
            'subject'      => 'required|string|max:255',
            'description'  => 'required|string',
            'lead_id'  => 'required',
            'attachments.*'=> 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xlsx|max:5120'
        ]);

        # create Fri record
        $fri = new Fri();
        // $fri->project     = $validated['project'];
        // $fri->client      = $validated['client'];
        $fri->category    = $validated['category'];
        $fri->priority    = $validated['priority'];
        $fri->due_date    = $validated['due_date'];
        $fri->assigned_to = $validated['assigned_to'];
        $fri->subject     = $validated['subject'];
        $fri->lead_id     = $validated['lead_id'];
        $fri->status     = $request->status;
        $fri->created_by = Auth::Id();
        $fri->description = $validated['description'];
        $fri->save();

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                # make sure folder exists
                $destinationPath = public_path('uploads/fri');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
        
                # generate unique name
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
                # move file to public/uploads/fri
                $file->move($destinationPath, $filename);
        
                # save relative path in DB
                $fri->images()->create([
                    'image_path' => 'uploads/fri/' . $filename
                ]);
            }
        }
        
        return redirect()->back()->with('success', 'RFI created successfully.');
    }

    public function listFri(Request $request)
	{
		$limit = $request->limit ?? 1; // limit per request
		$offset = $request->offset ?? 0;

		# fetch current batch
		$leads = Fri::with('createdByName','leadName')->orderBy('id', 'desc')
		->skip($offset)
			->take($limit)
			->get();

		# check if more data exists for next load
		$totalRecords = Fri::count();
		$hasMore = ($offset + $limit) < $totalRecords;

		return response()->json([
			'data' => $leads,
			'hasMore' => $hasMore
		]);
	}


    /**
     * Display the specified resource.
     */
    public function viewFri(string $id)
    {
        error_reporting(0);
        $this->data['fri'] =  Fri::with('images')->findOrFail($id);
        return view('admin.fri.details',$this->data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateFriStaus(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:fris,id',
            'status' => 'required|string|max:50',
        ]);

        $fri = Fri::find($request->id);
        $fri->status = $request->status;
        $fri->save();

        session()->flash('success', 'You have successfully update status!');
        return response()->json([
            'data'=>$fri,
            'success' => true,
            'message' => 'RFI status updated successfully.',
            'status' => $fri->status,
        ]);
    }

    # update fri
    public function friUpdate(Request $request)
    {
        # validate inputs
        $validated = $request->validate([
            // 'project'      => 'required|string|max:255',
            // 'client'       => 'required|string|max:255',
            'category'     => 'required|string|max:255',
            'priority'     => 'required|string|max:255',
            'due_date'     => 'required|date',
            'assigned_to'  => 'required|integer|exists:users,id',
            'subject'      => 'required|string|max:255',
            'description'  => 'required|string',
            'attachments.*'=> 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xlsx|max:5120'
        ]);

        # create Fri record
        $fri = Fri::find($request->id);
        // $fri->project     = $validated['project'];
        // $fri->client      = $validated['client'];
        $fri->category    = $validated['category'];
        $fri->priority    = $validated['priority'];
        $fri->due_date    = $validated['due_date'];
        $fri->assigned_to = $validated['assigned_to'];
        $fri->subject     = $validated['subject'];
        $fri->status     = $request->status;
        $fri->lead_id     = $request->lead_id;
        $fri->created_by = Auth::Id();
        $fri->description = $validated['description'];
        $fri->save();

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                # make sure folder exists
                $destinationPath = public_path('uploads/fri');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
        
                # generate unique name
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
                # move file to public/uploads/fri
                $file->move($destinationPath, $filename);
        
                # save relative path in DB
                $fri->images()->create([
                    'image_path' => 'uploads/fri/' . $filename
                ]);
            }
        }
        
        return redirect()->back()->with('success', 'RFI updated successfully.');
    }

   

}