<?php

namespace App\Http\Controllers;

use App\Models\tables;
use Illuminate\Http\Request;

class TablesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = tables::all();

        return view('tables.index', compact('tables'));
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
        tables::create($request->all());
        return back()->with('success', 'Table Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(tables $table)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(tables $table)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $table = tables::find($id);
        $table->update($request->only('name', 'location'));
        return back()->with('success', "Table Updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(tables $table)
    {
        //
    }
}
