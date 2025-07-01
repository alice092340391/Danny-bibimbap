<?php
// 連接資料庫
$servername = "localhost";
$username = "root";
$password = "123456789";
$dbname = "customer";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 取得客戶資料
$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$name = $data['name'];
$phone = $data['phone'];
$email = $data['email'];
$date = $data['date'];

// 更新資料庫中的客戶
$sql = "UPDATE customer SET name=?, phone=?, email=?, date=? WHERE Customer_ID=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $name, $phone, $email, $date, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}

$stmt->close();
$conn->close();
?>
