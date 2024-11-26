<?php
require_once 'functions.php';
$conexao = conectarBanco();

// Buscar perguntas ativas
$query = "SELECT * FROM perguntas WHERE status = TRUE ORDER BY id";
$resultado = pg_query($conexao, $query);
$perguntas = pg_fetch_all($resultado);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação - HRAV</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="submit.php" method="POST" id="form-avaliacao">
        <h1>Avaliação de Serviços</h1>
        <?php foreach ($perguntas as $pergunta): ?>
            <div class="pergunta">
                <label><?= htmlspecialchars($pergunta['texto']) ?></label>
                <div class="escala">
                    <?php for ($i = 0; $i <= 10; $i++): ?>
                        <label>
                            <input type="radio" name="respostas[<?= $pergunta['id'] ?>]" value="<?= $i ?>" required>
                            <?= $i ?>
                        </label>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <div class="feedback">
            <label>Feedback adicional (opcional):</label>
            <textarea name="feedback"></textarea>
        </div>
        <div class="anonimato">
            <p>Sua avaliação espontânea é anônima, nenhuma informação pessoal é solicitada ou armazenada.</p>
        </div>
        <button type="submit">Enviar Avaliação</button>
    </form>
    <script src="script.js"></script>
</body>
</html>
