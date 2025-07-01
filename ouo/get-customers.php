<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = 'localhost';
$username = 'root';
$password = '123456789';
$dbname = 'customer';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}

// todo
// $_GET['']

// 處理編輯客戶
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $edit_id = $conn->real_escape_string($_POST['edit_id']);
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $date = $conn->real_escape_string($_POST['date']);

    $sql_update = $conn->prepare("UPDATE customer SET name=?, phone=?, email=?, date=? WHERE customer_ID=?");
    $sql_update->bind_param("ssssi", $name, $phone, $email, $date, $edit_id);

    if ($sql_update->execute()) {
        echo json_encode(['status' => 'success', 'message' => '記錄更新成功']);
    } else {
        echo json_encode(['status' => 'error', 'message' => '錯誤: ' . $sql_update->error]);
    }

    $sql_update->close();
    exit;
}

// 查詢客戶資料
$sql = "SELECT * FROM customer";
$result = $conn->query($sql);

$customers = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $customers[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($customers);

$conn->close();
?>