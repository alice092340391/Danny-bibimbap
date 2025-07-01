<?php
//新增員工
// 資料庫連接信息
$servername = "localhost";
$username = "root";
$password = "123456789";
$dbname = "staff";

// 創建連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 檢查請求方法
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 檢查 POST 是否包含所需的字段
    if (isset($_POST['employee-name']) && isset($_POST['employee-gender']) &&
        isset($_POST['employee-position']) && isset($_POST['employee-phone']) &&
        isset($_POST['employee-email'])) {

        $name = $_POST['employee-name'];
        $gender = $_POST['employee-gender'];
        $position = $_POST['employee-position'];
        $phone = $_POST['employee-phone'];
        $email = $_POST['employee-email'];

        // 插入資料到資料庫
        $sql = "INSERT INTO staff (name, gender, position, phone, email) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $gender, $position, $phone, $email);

        $response = [];

        if ($stmt->execute()) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
            $response['message'] = "錯誤: " . $stmt->error;
        }

        // 關閉連接
        $stmt->close();
        $conn->close();

        // 返回 JSON 響應
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // 如果 POST 數據不完整，返回錯誤
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => '缺少必要的表單數據']);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => '無效的請求方法']);
}
?>
