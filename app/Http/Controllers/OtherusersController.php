<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
        $request->validate(
            [
                'name' => "unique:users,name|required",
            ]
        );

        User::create(
            [
                'name'      => $request->name,
                'role'      => $type,
                'password'  => Hash::make($request->password),
            ]
        );


    }
}
