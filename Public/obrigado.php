<?php
require_once '../src/db.php';


$pdo = conectarBD();


$setor_id = filter_input(INPUT_POST, 'setor_id', FILTER_VALIDATE_INT);
$dispositivo_id = filter_input(INPUT_POST, 'dispositivo_id', FILTER_VALIDATE_INT);
$nota = filter_input(INPUT_POST, 'nota', FILTER_VALIDATE_INT);
$feedback = filter_input(INPUT_POST, 'feedback', FILTER_SANITIZE_STRING);


if ($setor_id === null || $dispositivo_id === null || $nota === null) {
    die("Erro: Dados inválidos. Certifique-se de preencher todos os campos obrigatórios.");
}


try {
    $stmt = $pdo->prepare("
        INSERT INTO avaliacoes (setor_id, dispositivo_id, resposta, feedback) 
        VALUES (:setor_id, :dispositivo_id, :nota, :feedback)
    ");
    $stmt->execute([
        ':setor_id' => $setor_id,
        ':dispositivo_id' => $dispositivo_id,
        ':nota' => $nota,
        ':feedback' => $feedback ?: null,
    ]);
} catch (PDOException $e) {
    die("Erro ao registrar a avaliação. Por favor, tente novamente mais tarde.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obrigado!</title>
    <link rel="stylesheet" href="css/obrigado.css">
</head>
<body>
    <div class="container">
        <h1>Obrigado por sua Avaliação!</h1>
        <p>Sua resposta é de muita valia para nós.</p>
        <p>Você será redirecionado para a página inicial em <span id="contador">5</span> segundos...</p>
    </div>
    <script>
       
        let contador = 5; 
        const elementoContador = document.getElementById("contador");

        const intervalo = setInterval(() => {
            contador--;
            elementoContador.textContent = contador;

            if (contador === 0) {
                clearInterval(intervalo);
                window.location.href = "index.php";
            }
        }, 1000);
    </script>
</body>
</html>

