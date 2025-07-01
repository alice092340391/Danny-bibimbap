<?php
// 添加 CORS 頭部
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// 開啟錯誤報告
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 資料庫連接資訊
$servername = "localhost";
$username = "root";
$password = "123456789";
$dbname = "menu";

// 創建連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 獲取菜單數據
function getMenuData($conn) {
    $menus = array();
    
    // 套餐選擇
    $setMeals = array(
        array(
            'MenuID' => 1,
            'MenuName' => '豪華波奇',
            'Price' => 360,
            'ProteinChoices' => array('鮭魚', '鮮蝦'),
            'SideChoices' => array('水煮蛋','毛豆仁','杏鮑菇','玉米粒','紫薯泥'),
            'SauceChoices' => array('和風胡麻醬'),
            'SprinkleChoices' => array('香鬆','芝麻','海苔絲'),
        ),
        array(
            'MenuID' => 2,
            'MenuName' => '素食波奇',
            'Price' => 260,
            'ProteinChoices' => array('豆腐'),
            'SideChoices' => array('花椰菜', '小番茄', '秋葵', '鷹嘴豆', '地瓜泥'),
            'SauceChoices' => array('義式油醋醬'),
            'SprinkleChoices' => array('黑芝麻', '蒜酥'),
        ),
        array(
            'MenuID' => 3,
            'MenuName' => '簡單波奇',
            'Price' => 230,
            'ProteinChoices' => array('無蛋白質'),
            'SideChoices' => array('黑豆', '玉米筍', '黃金泡菜', '玉子燒', '海帶絲', '小黃瓜'),
            'SauceChoices' => array('柚香甜醬油'),
            'SprinkleChoices' => array('海苔絲'),
        )
    );

    // 自選內容
    $customOptions = array(
        'BaseChoices' => array('生菜', '紫米', '各半'),
        'SideChoices' => array(
            '毛豆仁', '花椰菜', '水煮蛋', '鷹嘴豆', '小番茄', '秋葵', '玉米粒', '小黃瓜',
            '地瓜泥', '紫薯泥 (+20元)', '海帶絲', '洋蔥', '玉子燒', '杏鮑菇', '黑豆', '玉米筍', '黃金泡菜'
        ),
        'ProteinChoices' => array(
            '無蛋白質', '鮭魚 (+70元)', '豆腐 (+50元)', '鮮蝦 (+70元)', '章魚 (+70元)', '鮪魚 (+70元)'
        ),
        'SauceChoices' => array(
            '辣美乃滋', '墨西哥辣醬', '和風胡麻醬', '柚香甜醬油', '義式油醋醬', '無醬料'
        ),
        'SprinkleChoices' => array(
            '黑芝麻', '核桐麥', '七味粉', '香鬆', '海苔絲', '蒜酥'
        )
    );

    // 飲料選擇
    $drinks = array(
        array(
            'DrinkID' => 1,
            'DrinkName' => '四季春冷泡茶',
            'DrinkPrice' => 38.00,
            'Image' => 'Tea.jpg',  // 替換為實際圖片路徑
        ),
        array(
            'DrinkID' => 2,
            'DrinkName' => '柚香清茶',
            'DrinkPrice' => 38.00,
            'Image' => 'grapefruit tea.jpg',  // 替換為實際圖片路徑
        ),
        array(
            'DrinkID' => 3,
            'DrinkName' => '無糖豆漿',
            'DrinkPrice' => 20.00,
            'Image' => 'soy milk.jpg',  // 替換為實際圖片路徑
            'ButtonText' => '加入訂單'
        ),
        array(
            'DrinkID' => 4,
            'DrinkName' => '紅茶',
            'DrinkPrice' => 25.00,
            'Image' => 'black tea.jpg',  // 替換為實際圖片路徑
        )
    );

    // 組合所有數據
    $data = array(
        'SetMeals' => $setMeals,
        'CustomOptions' => $customOptions,
        'Drinks' => $drinks
    );

    return $data;
}

// 處理請求
$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'add') {
        // 處理添加菜單項目
        $menuName = $_POST['menuName'];
        $price = $_POST['price'];
        $sql = "INSERT INTO menus (MenuName, Price) VALUES ('$menuName', $price)";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
    } elseif ($action === 'update') {
        // 處理修改菜單項目
        $menuID = $_POST['menuID'];
        $menuName = $_POST['menuName'];
        $price = $_POST['price'];
        $sql = "UPDATE menus SET MenuName='$menuName', Price=$price WHERE MenuID=$menuID";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
    }
} else {
    // 獲取菜單數據
    $data = getMenuData($conn);
    header('Content-Type: application/json');
    echo json_encode($data);
}

$conn->close();
?>
