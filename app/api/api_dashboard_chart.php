<?php
require_once "../config/database.php";
require_once "../model/Link.php";

session_start();
$userId = $_SESSION['user_id'] ?? null;

if(!$userId){
    http_response_code(403);
    echo json_encode(['error' => 'Acesso não autorizado']);
    exit();
}

$model = new Link();
$history = $model->getOverClicksHistoryOnDay($userId);

$labels = [];
$data = [];

foreach ($history as $row) {
    $labels[] = $row['dia'];
    $data[] = $row['total_cliques'];
}

$chartData = [
    'labels' => $labels,
    'data' => $data
];

header('Content-Type: application/json');
echo json_encode($chartData);
exit();

?>