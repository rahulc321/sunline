<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->data['cats'] = Category::where('type','mail')->get();
        return view('admin.category.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
             
            'status' => 'required',
            'name' => 'required|string|max:255|unique:categories,name'
        ]);

        if (Category::where('name', $request->source)->exists()) {
            session()->flash('error', 'source already exists!');   
            return redirect()
                ->back();
                 
        }

        Category::create(array_merge($request->all(), [
            'type' => 'mail'
        ]));

        return redirect()->route('admin.category.index')->with('success', 'You have successfully added!');
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
        $this->data['source'] = Category::find($id);
        return view('admin.category.edit',$this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $leadSource = Category::findOrFail($id);

        $request->validate([
            'status' => 'required',
            'name' => 'required|string|max:255|unique:categories,name,' . $leadSource->id,
        ]);

        $leadSource->update($request->all());

        return redirect()->route('admin.category.index')
            ->with('success', 'You have successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $leadSource = Category::find($id);
        $leadSource->delete();
        session()->flash('error', 'You have successfully deleted!');
        return back();
    }
}
