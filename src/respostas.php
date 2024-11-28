<?php
require_once '../src/funcoes.php';


$responseData = [
    'sectorId' => cleanInput($_POST['setor_id'], 'integer'),
    'deviceId' => cleanInput($_POST['dispositivo_id'], 'integer'),
    'score' => cleanInput($_POST['resposta'], 'integer'),
    'comments' => cleanInput($_POST['feedback'], 'string')
];


if (!$responseData['sectorId'] || !$responseData['deviceId'] || !$responseData['score']) {
    die("Campos faltantes");
}


if (insertRecord('avaliacoes', [
    'setor_id' => $responseData['sectorId'],
    'dispositivo_id' => $responseData['deviceId'],
    'resposta' => $responseData['score'],
    'feedback' => $responseData['comments'] ?: null
], '../public/index.php')) {
    echo "Resposta salva com sucesso";
} else {
    echo "Não salvou a resposta.";
}
