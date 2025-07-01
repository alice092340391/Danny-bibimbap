<?php 
header('Content-Type: application/json');

$servername = 'localhost';
$username = 'root';
$password = '123456789';
$dbname = 'menu';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => '連接失敗: ' . $conn->connect_error]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dish_name = isset($_POST['dish-name']) ? trim($_POST['dish-name']) : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';

    // 檢查資料是否合法
    if (!is_numeric($price) || empty($dish_name)) {
        echo json_encode(['success' => false, 'error' => '無效的輸入數據']);
        exit;
    }

    // 圖片上傳處理
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true); // 建立資料夾
    }

    $image_path = "";
    if (isset($_FILES['dish-image']) && $_FILES['dish-image']['error'] === 0) {
        $image_name = uniqid() . "_" . basename($_FILES["dish-image"]["name"]);
        $target_file = $upload_dir . $image_name;

        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["dish-image"]["tmp_name"], $target_file)) {
                $image_path = $target_file;
            } else {
                echo json_encode(['success' => false, 'error' => '圖片上傳失敗']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'error' => '只允許上傳 JPG, JPEG, PNG, GIF 格式']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'error' => '請選擇一張圖片']);
        exit;
    }

    // 寫入資料庫
    $stmt = $conn->prepare("INSERT INTO menus (MenuName, Price, ImagePath) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $dish_name, $price, $image_path);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => '新增成功']);
    } else {
        echo json_encode(['success' => false, 'error' => '資料庫錯誤: ' . $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
?>
