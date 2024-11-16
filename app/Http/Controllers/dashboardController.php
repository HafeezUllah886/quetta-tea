<?php

namespace App\Http\Controllers;

use App\Models\accounts;
use App\Models\expenses;
use App\Models\items;
use App\Models\products;
use App\Models\purchase_details;
use App\Models\sale_details;
use App\Models\sales;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dashboardController extends Controller
{
    public function index()
    {

           /*  if(auth()->user()->role != "Admin")
            {
                return to_route('orders.index');
            } */

        return view('dashboard.index');
    }
}
