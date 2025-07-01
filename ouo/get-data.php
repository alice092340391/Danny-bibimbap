<?php
// 獲取員工資料並填充表格
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "123456789";
$dbname = "staff"; // 確保資料庫名稱正確

// 創建連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 从 staff 表中查詢數據
$sql = "SELECT * FROM staff";
$result = $conn->query($sql);

if ($result === false) {
    die("SQL 查尋錯誤: " . $conn->error);
}

$staff = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $staff[] = $row;
    }
} 

header('Content-Type: application/json');
echo json_encode($staff);

$conn->close();
?>
