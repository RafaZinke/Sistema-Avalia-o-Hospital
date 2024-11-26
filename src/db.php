<?php
require_once 'functions.php';
$conexao = conectarBanco();

// Processar submissão
$respostas = $_POST['respostas'];
$feedback = $_POST['feedback'] ?? null;
$id_dispositivo = 1; // ID fixo para testes, substituir pela lógica real.

foreach ($respostas as $id_pergunta => $resposta) {
    $query = "INSERT INTO avaliacoes (id_setor, id_pergunta, id_dispositivo, resposta, feedback) 
              VALUES (1, $id_pergunta, $id_dispositivo, $resposta, $1)";
    $stmt = pg_prepare($conexao, "inserir_avaliacao", $query);
    pg_execute($conexao, "inserir_avaliacao", [$feedback]);
}

header("Location: obrigado.php");
exit;
?>
