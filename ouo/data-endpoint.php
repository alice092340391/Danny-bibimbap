<?php
//首頁(今日訂單數量)
header('Content-Type: application/json');

// 模擬動態數據
$data = [
    'orderCount' => rand(100, 200),
    'salesAmount' => rand(30000, 50000),
    'newCustomers' => rand(1, 10),
    'pendingOrders' => rand(5, 15),
    'salesTrendData' => [
        'labels' => ['January', 'February', 'March', 'April'],
        'values' => [rand(10000, 20000), rand(15000, 25000), rand(12000, 22000), rand(13000, 23000)]
    ],
    'inventoryLevelsData' => [
        'labels' => ['Product A', 'Product B', 'Product C'],
        'values' => [rand(30, 60), rand(20, 40), rand(10, 30)]
    ],
    'latestOrders' => array_map(function($i) {
        return ['id' => 12345 - $i, 'timeAgo' => rand(1, 30) . ' 分鐘前'];
    }, range(0, 2)),
    'systemNotification' => '系統將於今晚 12:00 進行維護，預計 2 小時。'
];

echo json_encode($data);
?>
