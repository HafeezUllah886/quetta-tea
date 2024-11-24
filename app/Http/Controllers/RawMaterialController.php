<?php

namespace App\Http\Controllers;

use App\Models\rawMaterial;
use App\Models\units;
use Illuminate\Http\Request;

class RawMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = rawMaterial::all();
        $units = units::all();
        return view('rawMaterial.index', compact('items', 'units'));
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
        $request->validate(
            [
                'name' => "unique:raw_materials,name",
            ],
            [
            'name.unique' => "Already Existing",
            ]
        );

        rawMaterial::create($request->all());

        return back()->with('success', 'Raw Material Created');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(rawMaterial $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => "unique:raw_materials,name,".$id,
            ],
            [
            'name.unique' => "Already Existing",
            ]
        );

        $item = rawMaterial::find($id);
        $item->update($request->all());

        return back()->with('success', 'Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(rawMaterial $item)
    {
        //
    }

    public function getMaterial($id)
    {
        $material = rawMaterial::find($id);

        return $material;
    }
}
