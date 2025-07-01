<?php
// 事件偵聽器更新菜單項
header('Content-Type: application/json');

// Database connection details
$servername = 'localhost';
$username = 'root';
$password = '123456789';
$dbname = 'menu';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Get data from POST request
$data = json_decode(file_get_contents('php://input'), true);

// Debug: Log received data
file_put_contents('debug.log', "Received data for update-menu.php: " . print_r($data, true) . "\n", FILE_APPEND);

if (isset($data['id']) && is_numeric($data['id']) && isset($data['name']) && !empty($data['name']) && isset($data['price']) && is_numeric($data['price'])) {
    $stmt = $conn->prepare("UPDATE menus SET MenuName=?, Price=? WHERE MenuID=?");
    $stmt->bind_param("sdi", $data['name'], $data['price'], $data['id']); // "s" for string, "d" for decimal, "i" for integer

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}

$conn->close();
?>
