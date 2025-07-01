<?php
//編輯員工資料
$servername = 'localhost';
$username = 'root';
$password = '123456789';
$dbname = 'staff';

// 創建連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die('連接失敗: ' . $conn->connect_error);
}

// 从 GET 請求中獲取 ID
$id = $_GET['id'] ?? null;

if ($id) {
    $sql = "SELECT * FROM staff WHERE member_ID=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $staff = $result->fetch_assoc();

    echo json_encode($staff);

    $stmt->close();
} else {
    echo json_encode(['error' => '缺少 ID']);
}

//$conn->close();
?>
