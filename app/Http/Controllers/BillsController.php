<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use App\Models\bills;
use App\Models\categories;
use App\Models\items;
use App\Models\sizes;
use Illuminate\Http\Request;

class BillsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bills = bills::all();
        return view('pos.index', compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = items::where('status', 'Active')->get();
        $categories = categories::all();
        $customers = accounts::Customer()->get();

        return view('pos.pos', compact('items', 'categories', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(bills $bills)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(bills $bills)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, bills $bills)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(bills $bills)
    {
        //
    }

    public function allItems()
    {
        $items = items::where('status', 'Active')->get();
        return response()->json(
            [
                'items' => $items,
            ]
        );
    }

    public function bycategory($id)
    {
        $items = items::where('catID', $id)->where('status', 'Active')->orderBy('name', 'asc')->get();

        return response()->json(
            [
                'items' => $items,
            ]
        );
    }

    public function addtocart(request $request)
    {
        $product = $request->itemID;
        $sizeName = "size$product";
        $sizeID = $request->$sizeName;

        $size = sizes::find($sizeID);
        return response()->json(
            [
                'itemname' => $size->item->name,
                'itemid' => $product,
                'sizename' => $size->title,
                'sizeid' => $sizeID,
                'price' => $size->price,
                'dprice' => $size->dprice,
                'image' => $size->item->img,
                'qty' => $request->qty,
                'time' => time(),
            ]
        );
    }
}
