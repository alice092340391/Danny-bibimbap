<?php
// app/Http/Controllers/Api/MenuController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu; // 確保你已經建立了 Menu 模型
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        // 只抓取 "is_available" = true 的菜單
        $menu = Menu::where('is_available', true)
                    ->get()
                    ->groupBy('category'); // 依據 'category' 欄位分組

        return response()->json($menu);
    }
}