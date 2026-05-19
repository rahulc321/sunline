<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tier;

class TierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $type = @$request->type;
        $this->data['tiers'] = Tier::where('category',$type)->get();
        return view('admin.tier.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        Tier::create($data);
        return redirect()->route('admin.tier.index')->with('success', 'You have successfully added!');
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
        $this->data['edit'] = Tier::find($id);
        return view('admin.tier.edit',$this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tier = Tier::findOrFail($id);
        $tier->update($request->all());

        return redirect()->route('admin.tier.index')->with('success', 'Tier updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Tier::find($id);
        $delete->delete();
        return redirect()->route('admin.tier.index')->with('error', 'You have successfully deleted!');
    }
}
