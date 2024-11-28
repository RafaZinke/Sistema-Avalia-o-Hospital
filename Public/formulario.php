<?php
require_once '../src/db.php';

$pdo = conectarBD();


$setor_id = filter_input(INPUT_GET, 'setor_id', FILTER_VALIDATE_INT);
$dispositivo_id = filter_input(INPUT_GET, 'dispositivo_id', FILTER_VALIDATE_INT);



$perguntas = $pdo->query("SELECT id, texto FROM perguntas WHERE status = 1 ORDER BY ordem ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação de Serviços</title>
    <link rel="stylesheet" href="css/formulario.css">
    <script src="js/formulario.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Avaliação de Serviços</h1>
        <form action="obrigado.php" method="POST">
           
            <input type="hidden" name="setor_id" value="<?= htmlspecialchars($setor_id) ?>">
            <input type="hidden" name="dispositivo_id" value="<?= htmlspecialchars($dispositivo_id) ?>">
            <input type="hidden" name="nota" id="nota">

            <div class="question">
                <label>Como você avalia o atendimento?</label>
                <div class="feedback-scale">
                    <label>
                        <input type="radio" name="resposta" value="2" data-nota="2">
                        <img src = "css/img/emoji-1.png" alt = "Muito Ruim" id = "emoji-1.png">
                        
                    </label>
                    <label>
                        <input type="radio" name="resposta" value="4" data-nota="4">
                        <img src = "css/img/emoji-2.png" alt = "Ruim" id = "emoji-2.png">
                       
                    </label>
                    <label>
                        <input type="radio" name="resposta" value="6" data-nota="6">
                        <img src = "css/img/emoji-3.png" alt = "Neutro" id = "emoji-3.png">
                        
                    </label>
                    <label>
                        <input type="radio" name="resposta" value="8" data-nota="8">
                        <img src = "css/img/emoji-4.png" alt = "Bom" id = "emoji-4.png">
                       
                    </label>
                    <label>
                        <input type="radio" name="resposta" value="10" data-nota="10">
                        <img src = "css/img/emoji-5.png" alt = "Excelente" id = "emoji-5.png">
                        
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="feedback">Comentários adicionais (Opcional) </label>
                <textarea id="feedback" name="feedback" placeholder="Escreva seu comentário aqui..."></textarea>
            </div>
            <button type="submit" class="btn-submit">Enviar Avaliação</button>
        </form>
    </div>
</body>
</html>

