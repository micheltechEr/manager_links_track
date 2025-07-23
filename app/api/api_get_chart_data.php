<?php
require_once '../config/database.php';
require_once '../models/LinkModel.php';

$link_id = filter_input(INPUT_GET, 'link_id', FILTER_VALIDATE_INT);

if (!$link_id) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'ID do link é obrigatório.']);
    exit();
}

$model = new LinkModel();
$history = $model->getClickHistoryForChart($link_id);

// Prepara os dados para o formato que o Chart.js gosta
$labels = []; // Eixo X (os dias)
$data = [];   // Eixo Y (a contagem de cliques)

foreach ($history as $row) {
    $labels[] = $row['dia'];
    $data[] = $row['total_cliques'];
}

// Monta o array final
$chartData = [
    'labels' => $labels,
    'data' => $data
];

// Define o cabeçalho para indicar que a resposta é JSON
header('Content-Type: application/json');

// Imprime a "bandeja" de dados em formato JSON e encerra
echo json_encode($chartData);
exit();