<?php
header('Content-Type: application/json');

// Database connection
$servername = 'localhost';
$username = 'root';
$password = '123456789';
$dbname = 'menu';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

// 清理輸入資料
$name = trim($data['name']);
$price = $data['price'];

if (!empty($name) && is_numeric($price)) {
    // 使用 LOWER() 並移除空白來查詢是否已有類似名稱
    $stmt = $conn->prepare("SELECT COUNT(*) FROM menus WHERE REPLACE(LOWER(MenuName), ' ', '') = REPLACE(LOWER(?), ' ', '')");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo json_encode(['success' => false, 'error' => '已有相同名稱的菜單']);
        $conn->close();
        exit;
    }

    // 如果沒有重複，新增資料
    $stmt = $conn->prepare("INSERT INTO menus (MenuName, Price) VALUES (?, ?)");
    $stmt->bind_param("sd", $name, $price);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => '新增成功']);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}

$conn->close();
