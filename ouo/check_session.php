<?php
session_start();

// 檢查用戶是否已登錄
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // 如果未登錄，請重定向到登錄頁面
    header("Location: login.html");
    exit;
}
?>