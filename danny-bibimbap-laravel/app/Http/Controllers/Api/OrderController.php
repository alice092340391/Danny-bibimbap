<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tableNumber' => 'required|string|max:10',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();
        $totalPrice = 0;

        DB::beginTransaction();
        try {
            $orderItemsData = [];
            foreach ($validatedData['items'] as $item) {
                $menuItem = Menu::find($item['id']);
                if (!$menuItem || !$menuItem->is_available) {
                    DB::rollBack();
                    return response()->json(['message' => '部分餐點已無法提供，請重新整理頁面。'], 400);
                }
                $price = $menuItem->price * $item['quantity'];
                $totalPrice += $price;

                $orderItemsData[] = [
                    'menu_id' => $menuItem->id,
                    'item_name' => $menuItem->name,
                    'quantity' => $item['quantity'],
                    'price' => $menuItem->price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $order = Order::create([
                'tableNumber' => $validatedData['tableNumber'],
                'totalPrice' => $totalPrice,
                'orderStatus' => '待處理',
                'customerName' => '現場客-' . $validatedData['tableNumber'],
                'customerPhone' => $validatedData['tableNumber'],
                'menuChoices' => json_encode([]),
            ]);

            foreach ($orderItemsData as &$data) {
                $data['order_id'] = $order->OrderID;
            }
            
            OrderItem::insert($orderItemsData);

            DB::commit();

            return response()->json([
                'message' => '訂單已成功送出！',
                'orderId' => $order->OrderID
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order submission failed: ' . $e->getMessage());
            return response()->json(['message' => '伺服器發生錯誤，請稍後再試。'], 500);
        }
    }
}
