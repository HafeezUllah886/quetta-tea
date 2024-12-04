<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\users_transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OtherusersController extends Controller
{
    public function index($type)
    {
        $checks = ['Waiter','Kitchen', 'Cashier', 'Customer', 'Store Keeper', 'Chef'];
        if(!in_array($type, $checks))
        {
            return back()->with('error', 'Invalid Request');
        }

        $users = User::where('role', $type)->get();

        return view('users.index', compact('users', 'type'));
    }

    public function store(request $request, $type)
    {

        try
        {

        DB::beginTransaction();

        $request->validate(
            [
                'name' => "unique:users,name|required",
            ],
            [
                'name.unique' => "User Name Already Used",
            ]
        );

        $user = User::create(
            [
                'name'      => $request->name,
                'role'      => $type,
                'password'  => Hash::make($request->password ?? rand(11111111,99999999)),
            ]
        );
        $ref = getRef();
        if($request->has('initial'))
        {
            createUserTransaction($user->id, now(), $request->initial, 0, "Initail Balance", $ref);
        }
        DB::commit();
        return back()->with('success', 'User Created');
    }
    catch(\Exception $e)
    {
        DB::rollBack();
        return back()->with('error', $e->getMessage());
    }


    }

    public function show($id, $from, $to)
    {
        $user = User::find($id);

        $transactions = users_transactions::where('userID', $id)->whereBetween('date', [$from, $to])->get();

        $pre_cr = users_transactions::where('userID', $id)->whereDate('date', '<', $from)->sum('cr');
        $pre_db = users_transactions::where('userID', $id)->whereDate('date', '<', $from)->sum('db');
        $pre_balance = $pre_cr - $pre_db;

        $cur_cr = users_transactions::where('userID', $id)->sum('cr');
        $cur_db = users_transactions::where('userID', $id)->sum('db');

        $cur_balance = $cur_cr - $cur_db;

        return view('users.statment', compact('user', 'transactions', 'pre_balance', 'cur_balance', 'from', 'to'));
    }

    public function update(request $request, $id)
    {

        try
        {

        DB::beginTransaction();

        $request->validate(
            [
                'name' => "unique:users,name,".$id."|required",
            ],
            [
                'name.unique' => "User Name Already Used",
            ]
        );
        $user = User::find($id);
        $user->update(
            [
                'name'      => $request->name,
            ]
        );
        if($request->password != "")
        {
            $user->update(
                [
                    'password'  => Hash::make($request->password),
                ]
            );
        }
        DB::commit();
        return back()->with('success', 'User Updated');
    }
    catch(\Exception $e)
    {
        DB::rollBack();
        return back()->with('error', $e->getMessage());
    }


    }
}
