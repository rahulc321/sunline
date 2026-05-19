<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Fri,FriImages};
use DB;
use App\{User};
use App\Models\Lead;
use Auth;
use Yajra\DataTables\Facades\DataTables;

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
			$query->where('title', env('ROLE'));
		})->get();


        $this->data['status'] = DB::table('statuses')->where('status', 1)->get();
        $this->data['priority'] = DB::table('priorities')->where('status',1)->get();
        $this->data['category'] = DB::table('categories')->where('status',1)->get();
        $this->data['leads'] = Lead::get();

        return view('admin.fri_new.index',$this->data);
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
        $limit = $request->limit ?? 10; // default limit
        $offset = $request->offset ?? 0;

        # build query
        $query = Fri::with(['createdByName', 'leadName','images'])
            ->orderBy('id', 'desc')->forCurrentUser();

        # apply filters
        if ($request->filled('search_key')) {
            $search = $request->search_key;
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        # clone query for total count
        $totalRecords = (clone $query)->count();

        # fetch current batch
        $leads = $query->skip($offset)
            ->take($limit)
            ->get();

        $hasMore = ($offset + $limit) < $totalRecords;

        return response()->json([
            'data' => $leads,
            'hasMore' => $hasMore,
            'totalRecords' => $totalRecords
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

        //session()->flash('success', 'You have successfully update status!');
        return redirect()->back()->with('success', 'You have successfully update status!');
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

    # uplaod rfi images
    public function fri_images(Request $request)
    {
        $request->validate([
            'fri_id' => 'required|integer',
            'file'   => 'required|file|max:2048'
        ]);

        # get original file name
        $originalName = $request->file('file')->getClientOriginalName();

        # move file to public/fri_images
        $file = $request->file('file');
        $file->move(public_path('fri_images'), $originalName);

        # store in db
        $image = FriImages::create([
            'fri_id'    => $request->fri_id,
            'image_path' => 'fri_images/' . $originalName
        ]);

        session()->flash('success', 'RFI imagesn updated successfully.');
         

        return response()->json([
            'file_name' => $originalName,
            'file_url'  => asset('fri_images/'.$originalName)
        ]);
    }



    public function listFritable(Request $request)
    {

        $query = Fri::with([
            'lead_name',
            'created_by_name',
            'assigned_user'
        ])
        ->withCount([
             
            'images'
        ])->forCurrentUser();

        if($request->search_key){

        $query->where('subject','like','%'.$request->search_key.'%');

        }

        if($request->status){

        $query->where('status',$request->status);

        }

        if($request->priority){

        $query->where('priority',$request->priority);

        }

        if($request->category){

        $query->where('category',$request->category);

        }

        return DataTables::of($query)

        ->addColumn('lead',function($row){

        return $row->lead_name
        ? $row->lead_name->first_name.' '.$row->lead_name->last_name
        : '-';

        })

        // subject

        ->addColumn('subject', function ($row) {

            $currentUserId = auth()->id();
            $counts = Fri::withCount([
                'replies as unread_replies_count' => function ($q) use ($currentUserId, $row) {
                    $q->whereNull('read_at')      
                    ->where('ticket_id',$row->id)
                    ->where('user_id', '!=', $currentUserId); // exclude current user's own replies
                }
            ])->where(function ($q) use ($currentUserId) {
                $q->where('assigned_to', $currentUserId)  // tickets assigned to current user
                ->orWhere('created_by', $currentUserId);   // tickets created by current user
            })->first(['unread_replies_count']);

            $dot = '';
        
            if ($counts->unread_replies_count > 0) {
                $dot = '<span class="notify-wrapper">
                            <span class="notify-dot"></span>
                        </span>';
            }
        
            return '
                <div class="d-flex align-items-center gap-2">

                    <span>'.$row->subject.' '.$dot.'</span>

                    <a 
                        href="javascript:void(0);" 
                        class="reply text-primary"
                        data-id="'.$row->id.'"
                        data-bs-toggle="modal"
                        data-bs-target="#replyModel">
                         - Reply
                    </a>

                </div>';
        
        })

        ->addColumn('responses',function($row){

        return $row->responses_count;

        })

        ->addColumn('attachments',function($row){

        return $row->images_count;

        })

        ->addColumn('created_by',function($row){

        return $row->created_by_name
        ? $row->created_by_name->name
        : '-';

        })

        ->addColumn('assigned_to',function($row){

        return $row->assigned_user
        ? $row->assigned_user->name
        : '-';

        })

        ->editColumn('status', function ($row) {

            # default color
            $class = 'bg-secondary';
        
            if ($row->status == 'Open') {
                $class = 'bg-primary';
            } elseif ($row->status == 'In Progress') {
                $class = 'bg-warning';
            } elseif ($row->status == 'Under Review') {
                $class = 'bg-info';
            } elseif ($row->status == 'Closed') {
                $class = 'bg-success';
            } elseif ($row->status == 'Cancelled') {
                $class = 'bg-danger';
            }
        
            return '<span class="badge '.$class.'">'.$row->status.'</span>';
        })

        ->editColumn('priority', function ($row) {

            # set default badge color
            $class = 'bg-secondary';
        
            if ($row->priority == 'High') {
                $class = 'bg-warning';
            } elseif ($row->priority == 'Medium') {
                $class = 'bg-info';
            } elseif ($row->priority == 'Low') {
                $class = 'bg-success';
            } elseif ($row->priority == 'Critical') {
                $class = 'bg-danger';
            }
        
            return '<span class="badge '.$class.'">'.$row->priority.'</span>';
        })

        ->addColumn('action', function ($row) {

            return '<a 
                href="'.route('admin.detailsRFI', $row->id).'" 
                class="text-primary">
                View More
            </a>';
        
        })

        ->rawColumns(['status','priority','action','subject'])

        ->make(true);

    }

    public function detailsRFI($id){

        $this->data['fri'] = Fri::with(['createdByName', 'leadName','images'])
            ->where('id', $id)->first();
        $this->data['users'] = User::whereHas('roles', function ($query) {
            $query->where('title', env('ROLE'));
        })->get();


        $this->data['status'] = DB::table('statuses')->where('status', 1)->get();
        $this->data['priority'] = DB::table('priorities')->where('status',1)->get();
        $this->data['category'] = DB::table('categories')->where('status',1)->get();
        $this->data['leads'] = Lead::get();

        return view('admin.fri_new.view',$this->data);
            
    }


   

}