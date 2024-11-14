<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OtherusersController extends Controller
{
    public function index($type)
    {
        $checks = ['Waiter','Kitchen', 'Cashier', 'Customer', 'Store Keeper'];
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
                'password'  => Hash::make($request->password),
            ]
        );
        DB::commit();
        return back()->with('success', 'User Created');
    }
    catch(\Exception $e)
    {
        DB::rollBack();
        return back()->with('error', $e->getMessage());
    }


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
