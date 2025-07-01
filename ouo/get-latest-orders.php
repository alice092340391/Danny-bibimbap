<?php
header('Content-Type: application/json');
echo json_encode([
    'orders' => [
        ['id' => 12345, 'time_ago' => '2 分鐘前'],
        ['id' => 12344, 'time_ago' => '10 分鐘前'],
        ['id' => 12343, 'time_ago' => '20 分鐘前']
    ]
]);
?>
