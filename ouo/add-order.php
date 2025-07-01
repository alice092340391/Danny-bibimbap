<?php
// 顯示錯誤訊息（開發階段建議啟用）
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 設定回應為 JSON
header('Content-Type: application/json');

// 取得前端傳來的資料
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => '未收到任何資料']);
    exit;
}

// 資料庫連線設定
$servername = 'localhost';
$username = 'root';
$password = '123456789';
$dbname = 'orders';

// 建立連線
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => '資料庫連線失敗: ' . $conn->connect_error]);
    exit;
}

// 資料清洗與安全處理
$customerName = $conn->real_escape_string($data['name'] ?? '');
$customerPhone = $conn->real_escape_string($data['phone'] ?? '');
$startDateTime = $conn->real_escape_string($data['startTime'] ?? '');
$endDateTime = $conn->real_escape_string($data['endTime'] ?? '');
$orderStatus = $conn->real_escape_string($data['status'] ?? '');
$tableNumber = $conn->real_escape_string($data['tableNumber'] ?? '');
$menuChoices = $conn->real_escape_string(json_encode($data['menuItems'] ?? []));
$totalPrice = $conn->real_escape_string($data['totalPrice'] ?? 0);

// SQL 插入語法
$sql = "INSERT INTO orders (
    customerName, customerPhone, startDateTime, endDateTime, tableNumber, menuChoices, totalPrice, orderStatus
) VALUES (
    '$customerName', '$customerPhone', '$startDateTime', '$endDateTime', '$tableNumber', '$menuChoices', '$totalPrice', '$orderStatus'
)";

// 執行 SQL
if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => '訂單新增成功']);
} else {
    echo json_encode(['success' => false, 'message' => '新增失敗: ' . $conn->error]);
}

$conn->close();
?>
