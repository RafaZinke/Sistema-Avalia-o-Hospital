<?php
require_once '../src/db.php'; 

$pdo = conectarBD();


$setores = $pdo->query("SELECT id, nome FROM setor WHERE status = 1 ORDER BY nome ASC")->fetchAll(PDO::FETCH_ASSOC);
$dispositivos = $pdo->query("SELECT id, nome FROM dispositivo WHERE status = 1 ORDER BY nome ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleção de Setor e Dispositivo</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="container">
        <h1>Selecione o Setor e Dispositivo</h1>
        <form action="formulario.php" method="GET">
          
            <div class="form-group">
                <label for="setor">Setor:</label>
                <select name="setor_id" id="setor" required>
                    <option value="">Escolha um setor</option>
                    <?php foreach ($setores as $setor): ?>
                        <option value="<?= $setor['id'] ?>"><?= htmlspecialchars($setor['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            
            <div class="form-group">
                <label for="dispositivo">Dispositivo:</label>
                <select name="dispositivo_id" id="dispositivo" required>
                    <option value="">Escolha um dispositivo</option>
                    <?php foreach ($dispositivos as $dispositivo): ?>
                        <option value="<?= $dispositivo['id'] ?>"><?= htmlspecialchars($dispositivo['nome']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            
            <button type="submit" class="btn">Iniciar Avaliação</button>
        </form>
    </div>
</body>
</html>
