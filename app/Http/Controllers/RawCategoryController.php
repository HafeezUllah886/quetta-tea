<?php

namespace App\Http\Controllers;

use App\Models\raw_categories;
use Illuminate\Http\Request;

class RawCategoryController extends Controller
{
  /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cats = raw_categories::orderBy('name', 'asc')->get();

        return view('rawMaterial.categories', compact('cats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        raw_categories::create($request->all());
        return back()->with('msg', 'Category Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(raw_categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(raw_categories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        raw_categories::find($id)->update($request->all());
        return back()->with('msg', 'Category Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(raw_categories $categories)
    {
        //
    }
}
