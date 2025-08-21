<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use App\Models\Lead;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $templates = EmailTemplate::all();
        return view('admin.email_templates.index', compact('templates'));
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

        EmailTemplate::create($request->only('subject','body','category','status'));

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
        $leadData = Lead::find($request->lead_id);
       // dd($request->all());
        sendGlobalEmail(
            $request->email,
            $request->subject,
            $request->body,
            $request->template_id,            # template_id
            $request->category,
            $request->lead_id,
            'lead',
            ['name' => $leadData->first_name.' '.$leadData->last_name]
        );
        return redirect()->back()->with('success', 'You have send email successfully!');
    }
}