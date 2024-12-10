<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use App\Models\bill_details;
use App\Models\bills;
use App\Models\categories;
use App\Models\item_beverages;
use App\Models\items;
use App\Models\sizes;
use App\Models\tables;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\table;

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
        $waiters = User::Waiters()->get();
        $tables = tables::where('status', 'Active')->get();
        $orders = bills::where('status', 'Active')->get();

        return view('pos.pos', compact('items', 'categories', 'customers', 'waiters', 'tables', 'orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try
        {
            DB::beginTransaction();
            $ref = getRef();
            $bill = bills::create(
                [
                  'waiterID'        => $request->waiter,
                  'customerID'      => 7,
                  'tableID'         => $request->table,
                  'date'            => date('Y-m-d'),
                  'type'            => $request->type,
                  'refID'           => $ref,
                ]
            );

            $items = $request->item;

            $total = 0;
            foreach($items as $key => $item)
            {

                bill_details::create(
                    [
                        'billID'        => $bill->id,
                        'itemID'        => $request->item[$key],
                        'sizeID'        => $request->size[$key],
                        'price'         => $request->price[$key],
                        'qty'           => $request->qty[$key],
                        'amount'        => $request->amount[$key],
                        'date'          => $bill->date,
                        'refID'         => $ref,
                    ]
                );
                $dealItems = item_beverages::where('itemID', $item)->get();

                foreach($dealItems as $deal)
                {
                    createStock($deal->rawID, 0, 1, $bill->date, "Issued in bill no. $bill->id", $ref);
                }

            }

            DB::commit();
            return response()->json(
                [
                    'status' => 'Saved',
                    'id' => $bill->id,
                ]
            );
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return response()->json(
                [
                    'status' => 'Error',
                    'msg' => $e->getMessage(),
                ]
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bill = bills::find($id);
        $bill->status = "Completed";
        $bill->save();

        return view('pos.print', compact('bill'));
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
