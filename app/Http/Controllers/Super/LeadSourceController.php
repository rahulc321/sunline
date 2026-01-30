<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeadSource;
use App\Models\Lead;

class LeadSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['leadSources'] = LeadSource::orderBy('id','DESC')->get();
        return view('admin.leadSources.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.leadSources.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
             
            'status' => 'required',
            'source' => 'required|string|max:255',
        ]);

        if (LeadSource::where('source', $request->source)->exists()) {
            session()->flash('error', 'source already exists!');   
            return redirect()
                ->back();
                 
        }

        LeadSource::create($request->all());

        return redirect()->route('admin.leadSource.index')->with('success', 'You have successfully added!');
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
        $this->data['source'] = LeadSource::find($id);
        return view('admin.leadSources.edit',$this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $leadSource = LeadSource::findOrFail($id);

        $request->validate([
            'status' => 'required',
            'source' => 'required|string|max:255|unique:lead_sources,source,' . $leadSource->id,
        ]);

        $leadSource->update($request->all());

        return redirect()->route('admin.leadSource.index')
            ->with('success', 'You have successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $leadSource = LeadSource::find($id);
        $leadSource->delete();
        session()->flash('error', 'You have successfully deleted!');
        return back();
    }
}