<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// 資料庫連線設定
$servername = "localhost";
$username = "root";
$password = "123456789";
$dbname = "menu";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["error" => "連線失敗: " . $conn->connect_error]));
}

// 讀取資料庫 menus 表中所有項目
$sql = "SELECT MenuID, MenuName, Price FROM menus ORDER BY MenuID DESC";
$result = $conn->query($sql);

$setMeals = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // 自動依據菜名選圖片
        $image = 'default-image.jpg';
        switch ($row['MenuName']) {
            case '豪華波奇':
                $image = 'Deluxe Poch.jpg';
                break;
            case '素食波奇':
                $image = 'Vegetarian Pochi.jpg';
                break;
            case '簡單波奇':
                $image = 'Simple Poch.jpg';
                break;
        }

        $setMeals[] = [
            "MenuID" => (int)$row["MenuID"],
            "MenuName" => $row["MenuName"],
            "Price" => (float)$row["Price"],
            "ProteinChoices" => [],
            "SideChoices" => [],
            "SauceChoices" => [],
            "SprinkleChoices" => [],
            "Image" => $image
        ];
    }
}

// 自選內容
$customOptions = [
    'BaseChoices' => ['生菜', '紫米', '各半'],
    'SideChoices' => [
        '毛豆仁', '花椰菜', '水煮蛋', '鷹嘴豆', '小番茄', '秋葵', '玉米粒', '小黃瓜',
        '地瓜泥', '紫薯泥 (+20元)', '海帶絲', '洋蔥', '玉子燒', '杏鮑菇', '黑豆', '玉米筍', '黃金泡菜'
    ],
    'ProteinChoices' => [
        '無蛋白質', '鮭魚 (+70元)', '豆腐 (+50元)', '鮮蝦 (+70元)', '章魚 (+70元)', '鮪魚 (+70元)'
    ],
    'SauceChoices' => [
        '辣美乃滋', '墨西哥辣醬', '和風胡麻醬', '柚香甜醬油', '義式油醋醬', '無醬料'
    ],
    'SprinkleChoices' => [
        '黑芝麻', '核桐麥', '七味粉', '香鬆', '海苔絲', '蒜酥'
    ]
];

// 飲料選項
$drinks = [
    ["DrinkID" => 1, "DrinkName" => "四季春冷泡茶", "DrinkPrice" => 38.00, "Image" => "Tea.jpg"],
    ["DrinkID" => 2, "DrinkName" => "柚香清茶", "DrinkPrice" => 38.00, "Image" => "grapefruit tea.jpg"],
    ["DrinkID" => 3, "DrinkName" => "無糖豆漿", "DrinkPrice" => 20.00, "Image" => "soy milk.jpg", "ButtonText" => "加入訂單"],
    ["DrinkID" => 4, "DrinkName" => "紅茶", "DrinkPrice" => 25.00, "Image" => "black tea.jpg"]
];

// 甜度與冰塊選項
$sweetnessOptions = [];
$iceOptions = [];

$result = $conn->query("SELECT OptionLabel FROM sweetness_options");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sweetnessOptions[] = $row['OptionLabel'];
    }
}

$result = $conn->query("SELECT OptionLabel FROM ice_options");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $iceOptions[] = $row['OptionLabel'];
    }
}

// 回傳 JSON
echo json_encode([
    "SetMeals" => $setMeals,
    "CustomOptions" => $customOptions,
    "Drinks" => $drinks,
    "SweetnessOptions" => $sweetnessOptions,
    "IceOptions" => $iceOptions
]);

$conn->close();
?>
