<?php
session_start(); // 啟動 session

$servername = "localhost";
$username = "root";
$password = "123456789";
$dbname = "customer";

// 創建連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 處理 CSV 文件導入
if (isset($_POST['import'])) {
    if ($_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['file']['tmp_name'];
        $handle = fopen($file, 'r');
        while (($data = fgetcsv($handle)) !== FALSE) {
            $name = $conn->real_escape_string($data[0]);
            $phone = $conn->real_escape_string($data[1]);
            $email = $conn->real_escape_string($data[2]);
            $date = $conn->real_escape_string($data[3]);

            // 檢查數據是否已存在
            $check_sql = "SELECT COUNT(*) AS count FROM customer WHERE email='$email'";
            $check_result = $conn->query($check_sql);
            $check_row = $check_result->fetch_assoc();
            
            if ($check_row['count'] == 0) {
                $sql = "INSERT INTO customer (name, phone, email, date) VALUES ('$name', '$phone', '$email', '$date')";
                $conn->query($sql);
            }
        }
        fclose($handle);
        echo "數據成功導入";
    } else {
        echo "文件上傳錯誤";
    }
}

// 處理 CSV 文件導出
if (isset($_POST['export'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=customer_data.csv');
    $output = fopen('php://output', 'w');
    
    fputcsv($output, ['姓名', '電話號碼', '郵箱', '註冊日期']);
    
    $result = $conn->query("SELECT name, phone, Email, date FROM customer");
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit();
}

// 處理編輯客戶
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $sql_edit = "SELECT * FROM customer WHERE customer_ID = $edit_id";
    $result_edit = $conn->query($sql_edit);
    $edit_row = $result_edit->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['Email'];
        $date = $_POST['date'];

        $sql_update = "UPDATE customer SET name='$name', phone='$phone', email='$email', date='$date' WHERE customer_ID=$edit_id";
        if ($conn->query($sql_update) === TRUE) {
            echo "記錄更新成功<br>";
            header("Location: customer.php");
        } else {
            echo "錯誤: " . $sql_update . "<br>" . $conn->error;
        }
    }
}

// 處理刪除客戶
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM customer WHERE customer_ID = $delete_id";
    if ($conn->query($sql_delete) === TRUE) {
        echo "記錄刪除成功<br>";
        header("Location: customer.php");
    } else {
        echo "錯誤: " . $sql_delete . "<br>" . $conn->error;
    }
}

// 獲取搜索關鍵字
$search = isset($_POST['search']) ? $_POST['search'] : '';

// 獲取排序字段和方向
$sort_field = isset($_GET['sort']) ? $_GET['sort'] : 'name';
$sort_order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

// 每頁顯示記錄數
$records_per_page = 5;

// 獲取當前頁碼
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// 執行查詢
$sql = "SELECT * FROM customer WHERE name LIKE '%$search%' ORDER BY $sort_field $sort_order LIMIT $offset, $records_per_page";
$result = $conn->query($sql);

// 查詢總記錄數
$sql_total = "SELECT COUNT(*) AS total FROM customer WHERE name LIKE '%$search%'";
$result_total = $conn->query($sql_total);
$total_rows = $result_total->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $records_per_page);

// 設置語言
putenv('LC_ALL=zh_CN');
setlocale(LC_ALL, 'zh_CN');
bindtextdomain('messages', './locale');
textdomain('messages');
?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>客戶列表</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f4f4f4; }
        .pagination a { margin: 0 5px; text-decoration: none; color: #007bff; }
        .pagination a.active { font-weight: bold; }
        .edit-form, .delete-form { display: none; }
    </style>
    <script>
        function showEditForm(id) {
            document.getElementById('edit-form').style.display = 'block';
            document.getElementById('edit_id').value = id;
        }

        function showDeleteForm(id) {
            if (confirm('確定刪除嗎?')) {
                window.location.href = 'customer.php?delete_id=' + id;
            }
        }
    </script>
</head>
<body>
    <h1><?php echo _("客戶列表"); ?></h1>

    <!-- 搜索和排序 -->
    <form method="POST" action="customer.php">
        <input type="text" name="search" placeholder="<?php echo _("搜尋"); ?>" value="<?php echo htmlspecialchars($search); ?>">
        <input type="submit" value="<?php echo _("搜尋"); ?>">
    </form>

    <div id="customer-list" class="dashboard">
        <table>
            <thead>
                <tr>
                    <th><a href="?sort=name&order=<?php echo ($sort_field == 'name' && $sort_order == 'ASC') ? 'DESC' : 'ASC'; ?>"><?php echo _("姓名"); ?></a></th>
                    <th><a href="?sort=phone&order=<?php echo ($sort_field == 'phone' && $sort_order == 'ASC') ? 'DESC' : 'ASC'; ?>"><?php echo _("電話"); ?></a></th>
                    <th><a href="?sort=email&order=<?php echo ($sort_field == 'Email' && $sort_order == 'ASC') ? 'DESC' : 'ASC'; ?>"><?php echo _("郵箱"); ?></a></th>
                    <th><a href="?sort=date&order=<?php echo ($sort_field == 'date' && $sort_order == 'ASC') ? 'DESC' : 'ASC'; ?>"><?php echo _("註冊日期"); ?></a></th>
                    <th><?php echo _("操作"); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["name"] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($row["phone"] ?? '') . "</td>";
                        echo "<td>" . htmlspecialchars($row["Email"] ?? '無') . "</td>";
                        echo "<td>" . htmlspecialchars($row["date"] ?? '') . "</td>";
                        echo "<td>";
                        echo "<button onclick=\"showEditForm(" . $row["Customer ID"] . ")\">" . _("編輯") . "</button> ";
                        echo "<button onclick=\"showDeleteForm(" . $row["Customer ID"] . ")\">" . _("刪除") . "</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>" . _("無數據") . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- 分頁 -->
    <div class="pagination">
        <?php if ($page > 1) { ?>
            <a href="?page=<?php echo $page - 1; ?>"><?php echo _("上一頁"); ?></a>
        <?php } ?>
        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
            <a href="?page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
        <?php } ?>
        <?php if ($page < $total_pages) { ?>
            <a href="?page=<?php echo $page + 1; ?>"><?php echo _("下一頁"); ?></a>
        <?php } ?>
    </div>

    <!-- 編輯表單 -->
    <div id="edit-form" class="edit-form">
        <h2><?php echo _("編輯客戶"); ?></h2>
        <form method="POST" action="customer.php">
            <input type="hidden" name="edit_id" id="edit_id" value="">
            <label><?php echo _("姓名"); ?>:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($edit_row['name'] ?? ''); ?>"><br>
            <label><?php echo _("電話"); ?>:</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($edit_row['phone'] ?? ''); ?>"><br>
            <label><?php echo _("郵箱"); ?>:</label>
            <input type="text" name="email" value="<?php echo htmlspecialchars($edit_row['email'] ?? ''); ?>"><br>
            <label><?php echo _("註冊日期"); ?>:</label>
            <input type="text" name="date" value="<?php echo htmlspecialchars($edit_row['date'] ?? ''); ?>"><br>
            <input type="submit" name="update" value="<?php echo _("更新"); ?>">
        </form>
    </div>

    <!-- CSV 導入和導出 -->
    <form method="post" enctype="multipart/form-data">
        <label for="file"><?php echo _("導入 CSV"); ?>:</label>
        <input type="file" name="file" id="file">
        <input type="submit" name="import" value="<?php echo _("導入"); ?>">
    </form>
    
    <form method="post">
        <input type="submit" name="export" value="<?php echo _("導出 CSV"); ?>">
    </form>
</body>
</html>

<?php
$conn->close(); // 關閉連接
?>
