<?php
header('Content-Type: application/json');
$conn = new mysqli('localhost', 'root', '123456789', 'orders');
if ($conn->connect_error) {
    die(json_encode(['error' => '資料庫連線失敗']));
}

// 今日訂單數量
$orderCountResult = $conn->query("SELECT COUNT(*) AS count FROM orders WHERE DATE(startDateTime) = CURDATE()");
$orderCount = $orderCountResult->fetch_assoc()['count'] ?? 0;

// 新增客戶數 (假設當天有多少不同客戶下單)
$newCustomersResult = $conn->query("SELECT COUNT(DISTINCT customerName) AS count FROM orders WHERE DATE(startDateTime) = CURDATE()");
$newCustomers = $newCustomersResult->fetch_assoc()['count'] ?? 0;

// 待處理訂單數量
$pendingOrdersResult = $conn->query("SELECT COUNT(*) AS count FROM orders WHERE orderStatus = '待處理'");
$pendingOrders = $pendingOrdersResult->fetch_assoc()['count'] ?? 0;

// 最新訂單（取最近3筆）
$latestOrdersResult = $conn->query("SELECT OrderID, startDateTime FROM orders ORDER BY startDateTime DESC LIMIT 3");
$latestOrders = [];
while ($row = $latestOrdersResult->fetch_assoc()) {
    $diff = strtotime('now') - strtotime($row['startDateTime']);
    $minutesAgo = floor($diff / 60);
    $latestOrders[] = [
        'OrderID' => $row['OrderID'],
        'minutesAgo' => $minutesAgo,
    ];
}

echo json_encode([
    'orderCount' => $orderCount,
    'newCustomers' => $newCustomers,
    'pendingOrders' => $pendingOrders,
    'latestOrders' => $latestOrders,
]);
