<?php
// 取得單筆訂單，給訂單管理編輯用
header('Content-Type: application/json');

if (!isset($_GET['OrderID'])) {
    echo json_encode(['success' => false, 'message' => '缺少OrderID']);
    exit;
}

$orderID = intval($_GET['OrderID']);

$servername = 'localhost';
$username = 'root';
$password = '123456789';
$dbname = 'orders';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => '連線失敗: '.$conn->connect_error]);
    exit;
}

$sql = "SELECT * FROM orders WHERE OrderID = $orderID LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // 嘗試解析 JSON，失敗就用原字串
    $decoded = json_decode($row['menuChoices'], true);
    $row['menuChoices'] = $decoded !== null ? $decoded : $row['menuChoices'];

    echo json_encode(['success' => true, 'order' => $row]);
} else {
    echo json_encode(['success' => false, 'message' => '找不到訂單']);
}

$conn->close();
?>
