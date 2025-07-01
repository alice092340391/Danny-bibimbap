<?php
// 數據庫連接信息
$servername = 'localhost';
$username = 'root';
$password = '123456789';
$dbname = 'users'; // 修改為實際的數據庫名稱

// 創建數據庫連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 假設你已经有用户ID
$user_id = 1; // 你可以根據登錄系统動態獲取

// 獲取用戶設置
$sql = "SELECT language, theme, notifications, profile_picture, email FROM users WHERE user_id=$id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 輸出數據為 JSON
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode([]);
}

// 關閉連接
$conn->close();
?>
