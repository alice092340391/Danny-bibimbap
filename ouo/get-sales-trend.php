<?php
header('Content-Type: application/json');
echo json_encode([
    'labels' => ['2024-08-01', '2024-08-02', '2024-08-03', '2024-08-04'],
    'values' => [3000, 4500, 2000, 4000]
]);
?>
