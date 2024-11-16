<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\items;
use App\Models\User;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = items::with('sizes')->orderBy('catID', 'asc')->get();

        return view('items.list', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cats = categories::orderBy('name', 'asc')->get();
        $kitchens = User::Kitchens()->get();
        return view('items.create', compact('cats', 'kitchens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => "unique:products,name",
            ],
            [
            'name.unique' => "Product already Existing",
            ]
        );

        $photo_path1 = null;
        if($request->hasFile('photo')){

            $image = $request->file('photo');
            $filename = $request->name.".".$image->getClientOriginalExtension();
            $image_path = public_path('/items/'.$filename);
            $photo_path1 = '/items/'.$filename;
            $image->move(public_path('/items/'), $filename);
        }

        items::create($request->all());

        return back()->with('success', 'Product Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($all)
    {
        $categories = categories::with('products')->get();
        return view('products.pricelist', compact('categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(products $products)
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
                'name' => "unique:products,name,".$id,
            ],
            [
            'name.unique' => "Product already Existing",
            ]
        );

        $product = products::find($id);
        $product->update($request->all());

        return back()->with('success', 'Product Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(products $products)
    {
        //
    }

    public function status($id)
    {
        $item = items::find($id);
        if($item->status == "Active")
        {
           $status = "Inactive";
        }
        else
        {
            $status = "Active";
        }

        $item->update(
            [
                'status' => $status,
            ]
        );

        return back()->with('success', "Status Updated");
    }
}
