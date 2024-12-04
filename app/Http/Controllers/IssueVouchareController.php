<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use App\Models\issueVouchare;
use App\Models\issueVouchareDetails;
use App\Models\rawMaterial;
use App\Models\stock;
use App\Models\units;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IssueVouchareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $start = $request->start ?? now()->toDateString();
        $end = $request->end ?? now()->toDateString();

        $vouchars = issueVouchare::whereBetween("date", [$start, $end])->orderby('id', 'desc')->get();
        return view('issue_vouchar.index', compact('vouchars', 'start', 'end'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = rawMaterial::orderby('name', 'asc')->get();
        foreach($products as $product)
        {
            $stock = getStock($product->id);
            $product->stock = $stock;
        }
        $units = units::all();
        $kitchens = User::kitchens()->get();
        $chefs = User::chefs()->get();
        return view('issue_vouchar.create', compact('products', 'units', 'kitchens', 'chefs'));
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
            $vouchar = issueVouchare::create(
                [
                  'kitchenID'  => $request->kitchenID,
                  'chefID'  => $request->chefID,
                  'date'        => $request->date,
                  'notes'       => $request->notes,
                  'refID'       => $ref,
                ]
            );

            $ids = $request->id;
            foreach($ids as $key => $id)
            {
                $unit = units::find($request->unit[$key]);
                $qty = $request->qty[$key] * $unit->value;
                issueVouchareDetails::create(
                    [
                        'voucharID'     => $vouchar->id,
                        'rawID'         => $id,
                        'qty'           => $request->qty[$key],
                        'unitID'        => $unit->id,
                        'unitID'        => $unit->id,
                        'unit_value'     => $unit->value,
                        'date'         => $request->date,
                        'refID'         => $ref,
                    ]
                );
                $kitchen = $vouchar->kitchen->name;
                createStock($id,0, $qty, $request->date, "Issued to $kitchen", $ref);
            }

          DB::commit();
            return to_route('issuevauchar.show', $vouchar->id)->with('success', "Vouchar Created");

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
    public function show(issueVouchare $issueVouchare)
    {
        return view('issue_vouchar.view', compact('issueVouchare'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(issueVouchare $issueVouchare)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, issueVouchare $issueVouchare)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(issueVouchare $issueVouchare)
    {
        //
    }

}
