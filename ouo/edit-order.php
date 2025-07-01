<?php
// 修改訂單
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['OrderID'])) {
    echo json_encode(['success' => false, 'message' => '無效的資料']);
    exit;
}

$servername = 'localhost';
$username = 'root';
$password = '123456789';
$dbname = 'orders';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => '連線失敗: '.$conn->connect_error]);
    exit;
}

$orderID = intval($data['OrderID']);
$customerName = $conn->real_escape_string($data['name'] ?? '');
$customerPhone = $conn->real_escape_string($data['phone'] ?? '');
$startDateTime = $conn->real_escape_string($data['startTime'] ?? '');
$endDateTime = $conn->real_escape_string($data['endTime'] ?? '');
$orderStatus = $conn->real_escape_string($data['status'] ?? '');
$tableNumber = $conn->real_escape_string($data['tableNumber'] ?? '');
$menuChoices = $conn->real_escape_string(json_encode($data['menuItems'] ?? []));

$sql = "UPDATE orders SET 
    customerName='$customerName', 
    customerPhone='$customerPhone', 
    startDateTime='$startDateTime', 
    endDateTime='$endDateTime',
    tableNumber='$tableNumber' 
    menuChoices='$menuChoices', 
    orderStatus='$orderStatus' 
    WHERE OrderID=$orderID";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => '修改成功']);
} else {
    echo json_encode(['success' => false, 'message' => '修改失敗: ' . $conn->error]);
}

$conn->close();
?>
