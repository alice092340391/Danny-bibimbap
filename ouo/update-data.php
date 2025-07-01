<?php
// 保存編輯的員工信息
$servername = 'localhost';
$username = 'root';
$password = '123456789';
$dbname = 'staff';

// 創建連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢測連接
if ($conn->connect_error) {
    die('連接失敗: ' . $conn->connect_error);
}

// 从 POST 請求中獲取數據
$id = $_POST['id'] ?? null;
$name = $_POST['name'] ?? null;
$gender = $_POST['gender'] ?? null;
$position = $_POST['position'] ?? null;
$phone = $_POST['phone'] ?? null;
$email = $_POST['email'] ?? null;

// 檢查是否所有必需的參數都已提供
if ($id && $name && $gender && $position && $phone && $email) {
    $sql = "UPDATE staff SET name=?, gender=?, position=?, phone=?, email=? WHERE member_ID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssi', $name, $gender, $position, $phone, $email, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => '缺少參數']);
}

$conn->close();
?>
