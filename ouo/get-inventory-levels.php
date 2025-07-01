<?php
header('Content-Type: application/json');
echo json_encode([
    'labels' => ['品項A', '品項B', '品項C'],
    'values' => [50, 30, 20]
]);
?>
