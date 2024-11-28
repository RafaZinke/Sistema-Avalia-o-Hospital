<?php

function conectarBD(){
    try {
        $host = 'localhost'; 
        $db = 'SistemaRafael'; 
        $user = 'postgres';
        $pass = 'postgres'; 
        $port = '5432'; 

        $dsn = "pgsql:host=$host;port=$port;dbname=$db;user=$user;password=$pass";

        $pdo = new PDO($dsn);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;

    } catch (PDOException $e) {
        error_log("Erro ao conectar: " . $e->getMessage());
        return null;
    }
}
