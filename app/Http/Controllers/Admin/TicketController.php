<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\User;
use App\Models\{Task, Fri};
use Auth;
use App\Models\TicketReply;
use App\Notifications\NewNotification;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        error_reporting(0);
        $this->data['users'] = User::whereHas('roles', function ($query) {
			$query->where('title', env('ROLE'));
		})->get();


        $this->data['ticket'] = Ticket::forCurrentUser()->get();

	 
		return view('admin.ticket.index',$this->data); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getTicket(Request $request)
    {
        $limit = $request->limit ?? 1; // limit per request
		$offset = $request->offset ?? 0;

		# fetch current batch
		$currentUserId = auth()->id();

        $tkt = Ticket::with(['getAssignUserName', 'submited'])
            ->where(function ($q) use ($currentUserId) {
                # include tickets assigned to current user
                $q->forCurrentUser()

                # include tickets created by current user
                ->orWhere('user_id', $currentUserId);
            })
            ->orderBy('id', 'desc')
            ->skip($offset)
            ->take($limit)
            ->get();

		# check if more data exists for next load
		$totalRecords = Ticket::count();
		$hasMore = ($offset + $limit) < $totalRecords;

		return response()->json([
			'data' => $tkt,
			'hasMore' => $hasMore
		]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {       

         $user = Auth::user(); // get current user
 
            if ($user->roles[0]->title == 'Sales Rep') {
        
                // count existing tickets by this user
                $highTicketsCount = Ticket::where('user_id', $user->id)
                    ->where('urgency_label', 'High')
                    ->count();
        
                $mediumTicketsCount = Ticket::where('user_id', $user->id)
                    ->where('urgency_label', 'Medium')
                    ->count();
        
                // check limits
                if ($request->urgency_label == 'High' && $highTicketsCount >= 1) {
                    return redirect()->back()->with('error', 'Sales Rep can only create 1 High priority ticket.');
                }
        
                if ($request->urgency_label == 'Medium' && $mediumTicketsCount >= 3) {
                    return redirect()->back()->with('error', 'Sales Rep can only create 3 Medium priority tickets.');
                }
            }

         

            $data = $request->all();
            $data['user_id'] = Auth::Id();
			Ticket::create($data);

            # for notification
			$user = User::find($request->assign_to);
			$user->notify(new NewNotification("🎟️ New ticket created for you!", @$request->subject, route('admin.ticket.index')));

			return redirect()->back()->with('success', 'You have successfully added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function closeTicket($id)
    {
        $ticket = Ticket::findOrFail($id);

        # update status
        $ticket->status = 'closed';
        $ticket->save();

        return redirect()->back()->with('success', 'Ticket closed successfully.');
    }

    # get ticket Replies
    public function ticketsRepliesList(Request $request, $ticketId)
    {
        $query = TicketReply::with('user:id,name')
            ->where('ticket_id', $ticketId);

        # if type is passed in request, apply filter
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $replies = $query->get()
            ->map(function ($reply) {
                $reply->created_at_formatted = $reply->created_at->format('Y-m-d g:i A');
                return $reply;
            });

        return response()->json($replies);
    }


    # save ticket reply
    public function ticketsReplies(Request $request, $ticketId)
    {
        // validate message and optional image
        $request->validate([
            'message'    => 'nullable|string|max:2000',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // find the ticket

        if($request->type == 'rfi'){
            $ticket = Fri::findOrFail($ticketId);
        }else{
            $ticket = Ticket::findOrFail($ticketId);
        }
        

        // create new reply
        $reply = new TicketReply();
        $reply->ticket_id = $ticket->id;
        $reply->user_id   = Auth::id(); // current logged-in user
        $reply->reply     = $request->message;
        if($request->type){
        $reply->type     = @$request->type;
        }

        // handle image upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ticket_replies'), $filename);
            $reply->attachment = 'uploads/ticket_replies/' . $filename;
        }

        $reply->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Reply added successfully',
            'reply'   => $reply
        ]);
    }

    # Update ticket
    public function ticketUpdate(Request $request,$id)
    {       
            $ticket = Ticket::find($id);
            $data = $request->all();
            $data['user_id'] = Auth::Id();
			$ticket->update($data);
			return redirect()->back()->with('success', 'You have successfully updated!');
    }

}