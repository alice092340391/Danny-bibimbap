<?php
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ob_start();

$servername = 'localhost';
$username = 'root';
$password = '123456789';
$dbname = 'orders';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    ob_clean();
    echo json_encode([
        'success' => false,
        'message' => '資料庫連接失敗: ' . $conn->connect_error
    ]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    ob_clean();
    echo json_encode([
        'success' => false,
        'message' => '無效的JSON數據'
    ]);
    exit;
}

if (!isset($data['name'], $data['phone'], $data['startTime'], $data['endTime'], $data['status'], $data['menuItems'])) {
    ob_clean();
    echo json_encode([
        'success' => false,
        'message' => '缺少必需欄位'
    ]);
    exit;
}

// 時間轉換：UTC -> 台北時區
try {
    $dtStart = new DateTime($data['startTime'], new DateTimeZone('UTC'));
    $dtStart->setTimezone(new DateTimeZone('Asia/Taipei'));
    $startTimeLocal = $dtStart->format('Y-m-d H:i:s');

    $dtEnd = new DateTime($data['endTime'], new DateTimeZone('UTC'));
    $dtEnd->setTimezone(new DateTimeZone('Asia/Taipei'));
    $endTimeLocal = $dtEnd->format('Y-m-d H:i:s');
} catch (Exception $e) {
    // 時間格式錯誤時使用原始字串
    $startTimeLocal = $data['startTime'];
    $endTimeLocal = $data['endTime'];
}

$sql = "INSERT INTO orders (customerName, customerPhone, startDateTime, endDateTime, orderStatus, menuChoices, totalPrice) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    ob_clean();
    echo json_encode([
        'success' => false,
        'message' => '準備 SQL 語句失敗: ' . $conn->error
    ]);
    exit;
}

$stmt->bind_param("ssssssd", 
    $data['name'], 
    $data['phone'], 
    $startTimeLocal, 
    $endTimeLocal, 
    $data['status'], 
    json_encode($data['menuItems'], JSON_UNESCAPED_UNICODE),
    $data['totalPrice']
);

if (!$stmt->execute()) {
    ob_clean();
    echo json_encode([
        'success' => false,
        'message' => '執行 SQL 語句失敗: ' . $stmt->error
    ]);
    exit;
}

$stmt->close();
$conn->close();

ob_clean();
echo json_encode([
    'success' => true,
    'message' => '訂單提交成功'
]);

ob_end_flush();
