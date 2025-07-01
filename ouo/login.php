<?php
session_start();

include("get-staff.php"); // 假設這個文件包含資料庫連接設定

// 設定預設密碼
$default_password = 'password123';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($conn->connect_error) {
        die("連接失敗: " . $conn->connect_error);
    }

    // 獲取 POST 輸入：員工編號和密碼
    $staff_id = isset($_POST['txtInterID']) ? trim($_POST['txtInterID']) : '';
    $password = isset($_POST['txtInterPassword']) ? trim($_POST['txtInterPassword']) : '';

    // 偵錯訊息：檢查是否接收到 POST 輸入
    if (empty($staff_id)) {
        echo "未接收到員工編號，請確認表單中的員工編號欄位是否正確。";
        exit;
    }
    if (empty($password)) {
        echo "未接收到密碼，請確認表單中的密碼欄位是否正確。";
        exit;
    }

    // 準備查詢語句以根據員工編號查找員工
    $query = "SELECT * FROM staff WHERE member_ID = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $staff_id); // 綁定員工編號
        $stmt->execute();
        $result = $stmt->get_result();

        // 檢查是否找到員工
        if ($result->num_rows > 0) {
            $staff = $result->fetch_assoc();
            
            // 驗證密碼
            if ($password === $default_password) {
                // 登入成功
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $staff['name']; // 儲存員工姓名
                $_SESSION['staff_id'] = $staff_id; // 儲存員工編號
                
                // 重定向到管理頁面
                header("Location: manage1.html");
                exit;
            } else {
                // 密碼錯誤
                echo "密碼錯誤。";
            }
        } else {
            // 找不到此員工
            echo "找不到此員工。";
        }
        $stmt->close();
    }
}
?>
