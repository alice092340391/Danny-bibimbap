<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menu = Menu::where('is_available', true)
                    ->get()
                    ->groupBy('category');

        return response()->json($menu);
    }
}