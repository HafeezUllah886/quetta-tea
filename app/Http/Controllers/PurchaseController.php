<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use App\Models\products;
use App\Models\purchase;
use App\Models\purchase_details;
use App\Models\purchase_payments;
use App\Models\rawMaterial;
use App\Models\stock;
use App\Models\transactions;
use App\Models\units;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $start = $request->start ?? now()->toDateString();
        $end = $request->end ?? now()->toDateString();

        $purchases = purchase::whereBetween("date", [$start, $end])->orderby('id', 'desc')->get();
        return view('purchase.index', compact('purchases', 'start', 'end'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $raw_materials = rawMaterial::orderby('name', 'asc')->get();
        $units = units::all();
        $vendors = accounts::vendor()->get();
        $accounts = accounts::business()->get();
        return view('purchase.create', compact('raw_materials', 'units', 'vendors', 'accounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try
        {
            if($request->isNotFilled('id'))
            {
                throw new Exception('Please Select Atleast One Product');
            }
            DB::beginTransaction();
            $ref = getRef();
            $purchase = purchase::create(
                [
                  'vendorID'        => $request->vendorID,
                  'date'            => $request->date,
                  'notes'           => $request->notes,
                  'refID'           => $ref,
                ]
            );

            $ids = $request->id;

            $total = 0;
            foreach($ids as $key => $id)
            {
                $unit = units::find($request->unit[$key]);
                $qty = ($request->qty[$key] * $unit->value);
                $qty1 = $request->qty[$key];
                $price = $request->price[$key];
                $amount = $price * $qty1;
                $total += $amount;

                purchase_details::create(
                    [
                        'purchaseID'    => $purchase->id,
                        'rawID'         => $id,
                        'price'         => $price,
                        'qty'           => $qty1,
                        'amount'        => $amount,
                        'date'          => $request->date,
                        'unitID'        => $unit->id,
                        'unitValue'     => $unit->value,
                        'refID'         => $ref,
                    ]
                );
                createStock($id, $qty, 0, $request->date, "Purchased in Purchase No. $purchase->id", $ref);

            }

            if($request->status == 'paid')
            {
                createTransaction($request->accountID, $request->date, 0, $total, "Payment of Purchase No. $purchase->id", $ref);
            }
            else
            {
                createTransaction($request->vendorID, $request->date, 0, $total, "Pending Amount of Purchase No. $purchase->id", $ref);
            }
            DB::commit();
            return back()->with('success', "Purchase Created");

        }
        catch(\Exception $e)
        {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(purchase $purchase)
    {
        return view('purchase.view', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(purchase $purchase)
    {
        $raws = rawMaterial::orderby('name', 'asc')->get();
        $units = units::all();
        $vendors = accounts::vendor()->get();
        $accounts = accounts::business()->get();
        return view('purchase.edit', compact('raws', 'units', 'vendors', 'accounts', 'purchase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, purchase $purchase)
    {
        try
        {
            if($request->isNotFilled('id'))
            {
                throw new Exception('Please Select Atleast One Product');
            }
            DB::beginTransaction();
            foreach($purchase->details as $product)
            {
                stock::where('refID', $product->refID)->delete();
                $product->delete();
            }
            transactions::where('refID', $purchase->refID)->delete();

            $purchase->update(
                [
                    'vendorID'        => $request->vendorID,
                    'date'            => $request->date,
                    'notes'           => $request->notes,
                  ]
            );

            $ids = $request->id;
            $ref = $purchase->refID;

            $total = 0;
            foreach($ids as $key => $id)
            {
                $unit = units::find($request->unit[$key]);
                $qty = ($request->qty[$key] * $unit->value);
                $qty1 = $request->qty[$key];
                $price = $request->price[$key];
                $amount = $price * $qty1;
                $total += $amount;

                purchase_details::create(
                    [
                        'purchaseID'    => $purchase->id,
                        'rawID'         => $id,
                        'price'         => $price,
                        'qty'           => $qty1,
                        'amount'        => $amount,
                        'date'          => $request->date,
                        'unitID'        => $unit->id,
                        'unitValue'     => $unit->value,
                        'refID'         => $ref,
                    ]
                );
                createStock($id, $qty, 0, $request->date, "Purchased in Purchase No. $purchase->id", $ref);

            }

            if($request->status == 'paid')
            {
                createTransaction($request->accountID, $request->date, 0, $total, "Payment of Purchase No. $purchase->id", $ref);
            }
            else
            {
                createTransaction($request->vendorID, $request->date, 0, $total, "Pending Amount of Purchase No. $purchase->id", $ref);
            }
            DB::commit();
            return back()->with('success', "Purchase Updated");

        }

        catch(\Exception $e)
        {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        try
        {
            DB::beginTransaction();
            $purchase = purchase::find($id);
            foreach($purchase->payments as $payment)
            {
                transactions::where('refID', $payment->refID)->delete();
                $payment->delete();
            }
            foreach($purchase->details as $product)
            {
                stock::where('refID', $product->refID)->delete();
                $product->delete();
            }
            transactions::where('refID', $purchase->refID)->delete();
            $purchase->delete();
            DB::commit();
            session()->forget('confirmed_password');
            return redirect()->route('purchase.index')->with('success', "Purchase Deleted");
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            session()->forget('confirmed_password');
            return redirect()->route('purchase.index')->with('error', $e->getMessage());
        }
    }

    public function getSignleProduct($id)
    {
        $product = products::find($id);
        return $product;
    }
}
