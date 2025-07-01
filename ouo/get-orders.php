<?php
header('Content-Type: application/json');

$servername = 'localhost';
$username = 'root';
$password = '123456789';
$dbname = 'orders';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => '連線失敗：' . $conn->connect_error]));
}

$sql = "SELECT OrderID, customerName, customerPhone, startDateTime, endDateTime, tableNumber, menuChoices, totalPrice, orderStatus FROM orders ORDER BY OrderID DESC";
$result = $conn->query($sql);

$orders = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

echo json_encode($orders);

$conn->close();
?>
