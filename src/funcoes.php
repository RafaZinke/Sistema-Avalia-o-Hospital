<?php
function conectarBanco() {
    $host = "localhost";
    $port = "5432";
    $dbname = "hospital";
    $user = "seu_usuario";
    $password = "sua_senha";
    $conexao = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");
    if (!$conexao) {
        die("Erro ao conectar ao banco de dados.");
    }
    return $conexao;
}
?>
