<?php
session_start();

// 檢查用戶是否已登入
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>後台管理</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .dashboard-container {
            margin-top: 50px;
            text-align: center;
        }
        .logout-button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container dashboard-container">
        <h1>歡迎, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>這是後台管理介面。您已成功登入。</p>
        <a href="logout.php" class="btn btn-danger logout-button">登出</a>
    </div>

    <!-- 必要的 JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
