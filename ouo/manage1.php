<?php
session_start();

// 檢查用户是否登入
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html");
    exit;
}

$userData = array(
    'id' => $_SESSION['staff_id'],
    'username' => $_SESSION['username'],
    'email' => 'johndoe@example.com',  // 這裡可以從數據庫中獲取實際的郵箱
    'fullname' => $_SESSION['username'],
    'age' => 30,  // 這些信息也可以從數據庫中獲取
    'city' => 'New York'
);

// 將使用者資料轉換成 JSON 格式
$userJson = json_encode($userData);

// 設定 HTTP 標頭為 JSON 格式
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

// 輸出 JSON 資料
echo $userJson;
?>