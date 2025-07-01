<?php
session_start(); // 啟動 session

$servername = "localhost";
$username = "root";
$password = "123456789";
$dbname = "staff"; // 這裡用的是 `staff`，如果你的數據庫名是 `staff`，這樣設定是對的

// 創建連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 處理表單提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"];
    $member_ID = $_POST["member_ID"];
    $name = $_POST["name"];
    $gender = $_POST["gender"] ?? ''; // 預設為空
    $position = $_POST["position"] ?? ''; // 預設為空
    $phone = $_POST["phone"] ?? ''; // 預設為空
    $email = $_POST["email"] ?? ''; // 預設為空

    if ($action == "insert") {
        // 檢查數據是否已經存在
        $check_stmt = $conn->prepare("SELECT * FROM member WHERE name=?");
        $check_stmt->bind_param("s", $name);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            echo "插入失敗: 員工已經存在";
        } else {
            // 插入數據
            $stmt = $conn->prepare("INSERT INTO member (name, gender, position, phone, email) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $gender, $position, $phone, $email);
            if ($stmt->execute()) {
                echo "插入成功";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        }
        $check_stmt->close();
    } elseif ($action == "update") {
        // 更新數據
        $stmt = $conn->prepare("UPDATE member SET name=?, gender=?, position=?, phone=?, email=? WHERE member_ID=?");
        $stmt->bind_param("sssssi", $name, $gender, $position, $phone, $email, $member_ID);
        if ($stmt->execute()) {
            echo "更新成功";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } elseif ($action == "delete") {
        // 刪除數據
        $stmt = $conn->prepare("DELETE FROM member WHERE member_ID=?");
        $stmt->bind_param("i", $member_ID);
        if ($stmt->execute()) {
            echo "刪除成功";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// 插入員工數據
$employees = [
    ['1', '熊熊', '男', '服務生', '1234567890', 'zhangsan@example.com'],
    ['2', '可可', '男', '廚師', '0987654321', 'lisi@example.com'],
    ['3', '王虎', '男', '收銀員', '1357924680', 'wangwu@example.com'],
    ['4', '小喵', '女', '服務生', '2468135790', 'xiaoming@example.com'],
    ['5', '黑曜石', '男', '廚師', '9876543210', 'xiaohua@example.com'],
    ['6', '丸子', '女', '經理', '6543217890', 'zhangsan@example.com'],
    ['7', '小柚', '女', '主廚', '3216549870', 'lisi@example.com'],
    ['8', '默黎', '男', '服務生', '4567891230', 'zhaoliu@example.com'],
    ['9', '小紅', '女', '櫃檯人員', '7894561230', 'xiaohong@example.com'],
    ['10', '米可', '男', '清潔工', '3692581470', 'xiaolong@example.com']
];

foreach ($employees as $employee) {
    // 檢查數據是否已經存在
    $check_stmt = $conn->prepare("SELECT * FROM member WHERE name=?");
    $check_stmt->bind_param("s", $employee[1]);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "插入失敗: 員工 " . $employee[1] . " 已經存在<br>";
    } else {
        // 插入數據
        $stmt = $conn->prepare("INSERT INTO member (member_ID, name, gender, position, phone, email) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $employee[0], $employee[1], $employee[2], $employee[3], $employee[4], $employee[5]);
        if ($stmt->execute()) {
            echo "插入成功: " . $employee[1] . "<br>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    $check_stmt->close();
}

// 查詢員工信息
$sql = "SELECT member_ID, name, gender, position, phone, email FROM member";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>員工管理</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>員工管理</h1>

    <form method="post" action="staff.php">
        <input type="hidden" name="action" value="insert">
        員工編號: <input type="number" name="member_ID" required><br>
        姓名: <input type="text" name="name" required><br>
        性別: <input type="text" name="gender" required><br>
        職位: <input type="text" name="position" required><br>
        電話: <input type="text" name="phone" required><br>
        郵箱: <input type="email" name="email" required><br>
        <input type="submit" value="插入">
    </form>

    <form method="post" action="staff.php">
        <input type="hidden" name="action" value="update">
        員工編號: <input type="number" name="member_ID" required><br>
        姓名: <input type="text" name="name" required><br>
        性別: <input type="text" name="gender"><br>
        職位: <input type="text" name="position"><br>
        電話: <input type="text" name="phone"><br>
        郵箱: <input type="email" name="email"><br>
        <input type="submit" value="更新">
    </form>

    <form method="post" action="staff.php">
        <input type="hidden" name="action" value="delete">
        員工編號: <input type="number" name="member_ID" required><br>
        <input type="submit" value="刪除">
    </form>

    <h2>員工列表</h2>
    <table>
        <tr>
            <th>員工編號</th>
            <th>姓名</th>
            <th>性別</th>
            <th>職位</th>
            <th>電話</th>
            <th>郵箱</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["member_ID"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["gender"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["position"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["phone"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>沒有找到員工信息</td></tr>";
        }
        ?>
    </table>

    <?php
    $conn->close();
    ?>
</body>
</html>
