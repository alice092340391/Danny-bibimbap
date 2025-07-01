<?php
$servername = 'localhost';
$username = 'root';
$password = '123456789';
$dbname = 'menu';

// 創建連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    die('連接失敗: ' . $conn->connect_error);
}

// 確保 POST 數據存在
if (!isset($_POST['name'], $_POST['phone'])) {
    die('缺少必要的字段。');
}

// 賦值
$name = $_POST['name'];
$phone = $_POST['phone'];
$base = $_POST['base'] ?? [];
$side = $_POST['side'] ?? [];
$protein = $_POST['protein'] ?? null;
$sauce = $_POST['sauce'] ?? [];
$sprinkle = $_POST['sprinkle'] ?? [];
$drink = $_POST['drink'] ?? null;

// 插入訂單數據的示例
$stmt = $conn->prepare("INSERT INTO Orders (name, phone) VALUES (?, ?)");
$stmt->bind_param('ss', $name, $phone);
$stmt->execute();
$orderId = $stmt->insert_id;
$stmt->close();

// 插入其他相關數據的示例（基底、配料、蛋白質、醬料、撒料、飲料）

// 插入基底選項的示例
foreach ($base as $baseId) {
    $stmt = $conn->prepare("INSERT INTO OrderBaseChoices (OrderID, BaseID) VALUES (?, ?)");
    $stmt->bind_param('ii', $orderId, $baseId);
    $stmt->execute();
    $stmt->close();
}

// 插入配料選項的示例
foreach ($side as $sideId) {
    $stmt = $conn->prepare("INSERT INTO OrderSideChoices (OrderID, SideID) VALUES (?, ?)");
    $stmt->bind_param('ii', $orderId, $sideId);
    $stmt->execute();
    $stmt->close();
}

// 插入蛋白質選項的示例
if ($protein) {
    $stmt = $conn->prepare("INSERT INTO OrderProteinChoices (OrderID, ProteinID) VALUES (?, ?)");
    $stmt->bind_param('ii', $orderId, $protein);
    $stmt->execute();
    $stmt->close();
}

// 插入醬汁選項的示例
foreach ($sauce as $sauceId) {
    $stmt = $conn->prepare("INSERT INTO OrderSauceChoices (OrderID, SauceID) VALUES (?, ?)");
    $stmt->bind_param('ii', $orderId, $sauceId);
    $stmt->execute();
    $stmt->close();
}

// 插入撒料選項的示例
foreach ($sprinkle as $sprinkleId) {
    $stmt = $conn->prepare("INSERT INTO OrderSprinkleChoices (OrderID, SprinkleID) VALUES (?, ?)");
    $stmt->bind_param('ii', $orderId, $sprinkleId);
    $stmt->execute();
    $stmt->close();
}

// 插入飲料選項的示例
if ($drink) {
    $stmt = $conn->prepare("INSERT INTO OrderDrinkChoices (OrderID, DrinkID) VALUES (?, ?)");
    $stmt->bind_param('ii', $orderId, $drink);
    $stmt->execute();
    $stmt->close();
}

$conn->close();

// 返回 JSON 回應
header('Content-Type: application/json');
echo json_encode([
    'name' => $name,
    'phone' => $phone,
    'base' => $base,
    'side' => $side,
    'protein' => $protein,
    'sauce' => $sauce,
    'sprinkle' => $sprinkle,
    'drink' => $drink
]);

echo '訂單已成功提交！';
?>
