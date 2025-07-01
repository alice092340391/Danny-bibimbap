<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = 'localhost';
$username = 'root';
$password = '123456789';
$dbname = 'customer';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $date = $conn->real_escape_string($_POST['date']);

    $sql_insert = $conn->prepare("INSERT INTO customer (name, phone, email, date) VALUES (?, ?, ?, ?)");
    $sql_insert->bind_param("ssss", $name, $phone, $email, $date);

    if ($sql_insert->execute()) {
        echo "紀錄插入成功";
    } else {
        echo "錯誤: " . $sql_insert->error;
    }

    $sql_insert->close();
}

$conn->close();
?>
