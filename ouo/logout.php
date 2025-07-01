<?php
session_start();
session_unset();
session_destroy();
header("Location: login.html");// 重定向到登入頁面
exit;
?>
