<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\Lead;
use App\Models\LeadSource;

class EmailTemplateController extends Controller
{
    public function index(Request $request)
    {
        $query = EmailTemplate::query();

        // search filter
        if ($request->filled('search_key')) {
            $search = $request->search_key;
            $query->where(function ($q) use ($search) {
                
                $q->orWhere('subject', 'like', "%{$search}%")
                ->orWhere('body', 'like', "%{$search}%");
            });
        }

        // category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // get results (with pagination if needed)
        $templates = $query->orderBy('id', 'desc')->paginate(10);
        $leadSource = LeadSource::where('status',1)->get();
        return view('admin.email_templates.index', compact('templates','leadSource'));
    }


    public function create()
    {
        return view('admin.email_templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'category' => 'required|string',
            'status' => 'required|string',
        ]);
       // dd($request->all());
        EmailTemplate::create($request->all());

        return redirect()->back()->with('success', 'Email Template created successfully!');
    }

    public function edit($id)
    {
        $template = EmailTemplate::findOrFail($id);
        return view('admin.email_templates.edit', compact('template'));
    }

    public function emailTemplateUpdate(Request $request)
    {
        $template = EmailTemplate::findOrFail($request->id);

        $request->validate([
            'subject' => 'required',
            'body' => 'required',
        ]);

        $template->update($request->all());

        return redirect()->route('admin.emailTemplate.index')
                         ->with('success', 'Email template updated successfully.');
    }

    public function destroy($id)
    {
        EmailTemplate::destroy($id);

        return redirect()->route('admin.emailTemplate.index')
                         ->with('success', 'Email template deleted successfully.');
    }

    # Send lead email
    public function sendEmail(Request $request){
        $leadData = Lead::with(['getAssignUserName'])->where('id',$request->lead_id)->first();
        $owner = $leadData->getAssignUserName->name ?? '-';
        //echo '<pre>';print_r($owner);die;
        sendGlobalEmail(
            $request->email,
            $request->subject,
            $request->body,
            $request->template_id,            # template_id
            $request->category,
            $request->lead_id,
            'lead',
            ['name' => $leadData->first_name.' '.$leadData->last_name,'email'=>$request->email,'address'=>$leadData->address,'owner'=>$owner]
        );
        return redirect()->back()->with('success', 'You have send email successfully!');
    }

    public function bulkEmail(){
        $this->data['leads'] =  Lead::where('status','New')->get();
        $this->data['emailTemplates'] =  EmailTemplate::get();
        
        return view('admin.bulk_email.index',$this->data);
    }

    public function bulkEmailSend(Request $request)
    {
        $request->validate([
            'emails'      => 'required|array',
            'subject'     => 'required|string',
            'body'        => 'required|string',
            'template_id' => 'nullable|integer'
        ]);

        
        foreach ($request->emails as $email) {

            // Fetch Lead Row (if exists)
            $leadData = Lead::where('email', $email)->first();

            // Prepare dynamic variables
            $variables = [
                'name'  => $leadData?->first_name . ' ' . $leadData?->last_name ?? 'User',
                'email' => $email,
            ];

            sendGlobalEmail1(
                $email,
                $request->subject,
                $request->body,
                $request->template_id,
                null,
                $leadData?->id ?? null,   // Safe lead id
                'lead',
                $variables
            );
        }

        return back()->with('success', 'Bulk email sent successfully!');
    }

}