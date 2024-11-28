<?php
require_once '../src/db.php';

$pdo = conectarBD();

// Capturar os dados enviados pelo formulário
$setor_id = filter_input(INPUT_POST, 'setor_id', FILTER_VALIDATE_INT);
$dispositivo_id = filter_input(INPUT_POST, 'dispositivo_id', FILTER_VALIDATE_INT);
$nota = filter_input(INPUT_POST, 'nota', FILTER_VALIDATE_INT);
$feedback = filter_input(INPUT_POST, 'feedback', FILTER_SANITIZE_STRING);

if (!$setor_id || !$dispositivo_id || !$nota) {
    die("Dados inválidos!");
}

// Inserir no banco de dados
$stmt = $pdo->prepare("
    INSERT INTO avaliacoes (setor_id, dispositivo_id, resposta, feedback) 
    VALUES (:setor_id, :dispositivo_id, :nota, :feedback)
");
$stmt->execute([
    ':setor_id' => $setor_id,
    ':dispositivo_id' => $dispositivo_id,
    ':nota' => $nota,
    ':feedback' => $feedback ?: null
]);

// Redirecionar para a página de obrigado
header("Location: obrigado.php");
exit;
?>
