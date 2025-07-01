<?php
header('Content-Type: application/json');

// 資料庫連接信息
$servername = "localhost";
$username = "root";
$password = "123456789";
$dbname = "menu";

// 創建連接
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連接
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed']);
    exit;
}

// 查詢自訂選項
$baseSql = "SELECT BaseName FROM BaseChoices";
$baseResult = $conn->query($baseSql);

$baseChoices = [];
if ($baseResult->num_rows > 0) {
    while($base = $baseResult->fetch_assoc()) {
        $baseChoices[] = $base['BaseName'];
    }
}

// 查詢配料選擇
$sideSql = "SELECT SideName FROM SideChoices";
$sideResult = $conn->query($sideSql);

$sideChoices = [];
if ($sideResult->num_rows > 0) {
    while($side = $sideResult->fetch_assoc()) {
        $sideChoices[] = $side['SideName'];
    }
}

// 查詢蛋白質選擇
$proteinSql = "SELECT ProteinName FROM ProteinChoices";
$proteinResult = $conn->query($proteinSql);

$proteinChoices = [];
if ($proteinResult->num_rows > 0) {
    while($protein = $proteinResult->fetch_assoc()) {
        $proteinChoices[] = $protein['ProteinName'];
    }
}

// 查詢醬料選擇
$sauceSql = "SELECT SauceName FROM SauceChoices";
$sauceResult = $conn->query($sauceSql);

$sauceChoices = [];
if ($sauceResult->num_rows > 0) {
    while($sauce = $sauceResult->fetch_assoc()) {
        $sauceChoices[] = $sauce['SauceName'];
    }
}

// 查詢灑料選擇
$sprinkleSql = "SELECT SprinkleName FROM SprinkleChoices";
$sprinkleResult = $conn->query($sprinkleSql);

$sprinkleChoices = [];
if ($sprinkleResult->num_rows > 0) {
    while($sprinkle = $sprinkleResult->fetch_assoc()) {
        $sprinkleChoices[] = $sprinkle['SprinkleName'];
    }
}

// 查詢飲料選擇
$drinkSql = "SELECT DrinkName, DrinkPrice FROM DrinkChoices";
$drinkResult = $conn->query($drinkSql);

$drinkChoices = [];
if ($drinkResult->num_rows > 0) {
    while($drink = $drinkResult->fetch_assoc()) {
        $drinkChoices[] = [
            'name' => $drink['DrinkName'],
            'price' => $drink['DrinkPrice']
        ];
    }
}

// 關閉連接
$conn->close();

// 返回結果
echo json_encode([
    'baseChoices' => $baseChoices,
    'sideChoices' => $sideChoices,
    'proteinChoices' => $proteinChoices,
    'sauceChoices' => $sauceChoices,
    'sprinkleChoices' => $sprinkleChoices,
    'drinkChoices' => $drinkChoices
]);
?>
