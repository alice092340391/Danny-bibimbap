<?php
// 連接數據庫
$servername = "localhost";
$username = "root";
$password = "123456789";
$dbname = "customer";  // 假設的資料庫名

$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接是否成功
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => '資料庫連接失敗']));
}

// 解析 JSON 請求
$data = json_decode(file_get_contents('php://input'), true);

// 檢查是否有傳遞所需的參數
if (isset($data['Customer_ID']) && isset($data['name']) && isset($data['phone']) && isset($data['email']) && isset($data['date'])) {
    $id = $conn->real_escape_string($data['Customer_ID']);
    $name = $conn->real_escape_string($data['name']);
    $phone = $conn->real_escape_string($data['phone']);
    $email = $conn->real_escape_string($data['email']);
    $date = $conn->real_escape_string($data['date']);

    // 更新 SQL 查詢
    $sql = "UPDATE customer SET name='$name', phone='$phone', email='$email', date='$date' WHERE Customer_ID=$id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => '更新失敗']);
    }
} else {
    echo json_encode(['success' => false, 'message' => '缺少參數']);
}

// 關閉數據庫連接
$conn->close();
?>
