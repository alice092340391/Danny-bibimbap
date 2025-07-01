<?php
$servername = 'localhost';
$username = 'root';
$password = '123456789';
$dbname = 'staff';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die('連接失敗: ' . $conn->connect_error);
}

$employee_name = $_POST['employee_name'];
$shift_date = $_POST['shift_date'];
$shift_time = $_POST['shift_time'];
$shift_duration = $_POST['shift_duration'];

$sql = "INSERT INTO schedule (employee_name, shift_date, shift_time, shift_duration) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssi', $employee_name, $shift_date, $shift_time, $shift_duration);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
