<?php
session_start();

// 將表單提交的設置保存到 Session
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['language'] = $_POST['language'];
    $_SESSION['theme'] = $_POST['theme'];
    $_SESSION['notifications'] = isset($_POST['notifications']) ? 'on' : 'off';
    $_SESSION['profile-picture'] = $_POST['profile-picture'];
    $_SESSION['email'] = $_POST['email'];

    // 重新導向回到設置頁面
    header('Location: settings.php');
    exit();
}
