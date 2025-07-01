<?php
header('Content-Type: application/json');

// 資料庫連接信息
$servername = "localhost";
$username = "root";
$password = "123456789";
$dbname = "menu";

// 創建連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed']);
    exit;
}

// 獲取 POST 數據
$data = json_decode(file_get_contents('php://input'), true);

// 驗證數據
if (!isset($data['name']) || !isset($data['phone']) || !isset($data['pickup-time']) || !isset($data['order'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit;
}

// 儲存訂單
$orderSql = "INSERT INTO Orders (name, phone, pickup_time) VALUES (?, ?, ?)";
$stmt = $conn->prepare($orderSql);
$stmt->bind_param('sss', $data['name'], $data['phone'], $data['pickup-time']);

if ($stmt->execute()) {
    $orderId = $stmt->insert_id; // 獲取訂單 ID

    // 儲存訂單詳細信息
    $orderDetailsSql = "INSERT INTO OrderDetails (OrderID, MenuID, Protein, Side, Sauce, Sprinkle) VALUES (?, ?, ?, ?, ?, ?)";
    $orderDetailsStmt = $conn->prepare($orderDetailsSql);

    foreach ($data['order'] as $item) {
        $orderDetailsStmt->bind_param('iissss', $orderId, $item['menuId'], $item['protein'], $item['side'], $item['sauce'], $item['sprinkle']);
        $orderDetailsStmt->execute();
    }

    $orderDetailsStmt->close();
    $stmt->close();
    $conn->close();

    echo json_encode(['success' => true, 'message' => 'Order submitted successfully']);
} else {
    $stmt->close();
    $conn->close();
    echo json_encode(['success' => false, 'message' => 'Failed to submit order']);
}
?>
