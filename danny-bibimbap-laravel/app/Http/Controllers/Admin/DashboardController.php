<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $todayOrderCount = Order::whereDate('created_at', Carbon::today())->count();

        $todayRevenue = Order::whereDate('created_at', Carbon::today())->sum('totalPrice');

        $pendingOrderCount = Order::where('orderStatus', '待處理')->count();

        $latestOrders = Order::latest()->take(5)->get();

        return view('admin.dashboard.index', [
            'todayOrderCount' => $todayOrderCount,
            'todayRevenue' => $todayRevenue,
            'pendingOrderCount' => $pendingOrderCount,
            'latestOrders' => $latestOrders,
        ]);
    }
}

