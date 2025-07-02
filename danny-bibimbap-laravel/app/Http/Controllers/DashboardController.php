<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $orderCount = DB::table('orders')->whereDate('startDateTime', today())->count();
        $newCustomers = DB::table('orders')->whereDate('startDateTime', today())->distinct('customerName')->count('customerName');
        $pendingOrders = DB::table('orders')->where('orderStatus', '待處理')->count();

        return view('manage.dashboard', [
            'orderCount' => $orderCount,
            'newCustomers' => $newCustomers,
            'pendingOrders' => $pendingOrders,
        ]);
    }
}