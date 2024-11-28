<?php
require_once '../src/funcoes.php';

// Variáveis renomeadas
$responseData = [
    'sectorId' => cleanInput($_POST['setor_id'], 'integer'),
    'deviceId' => cleanInput($_POST['dispositivo_id'], 'integer'),
    'score' => cleanInput($_POST['resposta'], 'integer'),
    'comments' => cleanInput($_POST['feedback'], 'string')
];

// Validação de campos obrigatórios
if (!$responseData['sectorId'] || !$responseData['deviceId'] || !$responseData['score']) {
    die("Error: Missing required fields.");
}

// Inserir no banco
if (insertRecord('avaliacoes', [
    'setor_id' => $responseData['sectorId'],
    'dispositivo_id' => $responseData['deviceId'],
    'resposta' => $responseData['score'],
    'feedback' => $responseData['comments'] ?: null
], '../public/index.php')) {
    echo "Response successfully recorded!";
} else {
    echo "Failed to save response.";
}
