<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'db.php';
require_once 'GerenciadorMensagem.php';

// Renomeação e ajuste de funções
function cleanInput($value, $type = 'string') {
    switch ($type) {
        case 'string':
            return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
        case 'integer':
            return filter_var($value, FILTER_VALIDATE_INT);
        case 'float':
            return filter_var($value, FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        default:
            return $value;
    }
}

function fetchTableData($tableName, $conditions = [], $fields = '*', $sort = '', $limit = null) {
    try {
        $dbConnection = conectarBD();
        $redirectPage = '../public/index.php';

        if (!$dbConnection) {
            throw new Exception("Unable to connect to the database.");
        }

        $query = "SELECT $fields FROM $tableName";

        if (!empty($conditions)) {
            $clauses = [];
            foreach ($conditions as $column => $value) {
                if (is_array($value) && $value[0] === 'between') {
                    $clauses[] = "$column BETWEEN :${column}_start AND :${column}_end";
                } else {
                    $clauses[] = "$column = :$column";
                }
            }
            $query .= " WHERE " . implode(' AND ', $clauses);
        }

        if (!empty($sort)) {
            $query .= " ORDER BY $sort";
        }

        if ($limit) {
            $query .= " LIMIT $limit";
        }

        $statement = $dbConnection->prepare($query);

        foreach ($conditions as $column => $value) {
            if (is_array($value) && $value[0] === 'between') {
                $startDate = $value[1] . ' 00:00:00';
                $endDate = $value[2] . ' 23:59:59';

                $statement->bindValue(":${column}_start", $startDate);
                $statement->bindValue(":${column}_end", $endDate);
            } else {
                $statement->bindValue(":$column", $value);
            }
        }

        if (!$statement->execute()) {
            throw new Exception("Failed to execute query.");
        }

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        GerenciadorMensagem::tratarErro($e, $redirectPage);
    } finally {
        $dbConnection = null;
    }
}

function insertRecord($table, $data, $redirectSection) {
    try {
        $dbConnection = conectarBD();

        if (!$dbConnection) {
            throw new Exception("Database connection failed.");
        }

        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $statement = $dbConnection->prepare($query);

        if ($statement->execute($data)) {
            GerenciadorMensagem::definirMensagem('Record successfully added!', 'success', $redirectSection);
        } else {
            throw new Exception("Failed to insert record.");
        }
    } catch (Exception $e) {
        GerenciadorMensagem::tratarErro($e, $redirectSection);
    }
}

function processFilters() {
    $filters = [];

    if (!empty($_GET['setor_id'])) {
        $filters['setor_id'] = $_GET['setor_id'];
    }

    if (!empty($_GET['pergunta_id'])) {
        $filters['pergunta_id'] = $_GET['pergunta_id'];
    }

    if (!empty($_GET['dispositivo_id'])) {
        $filters['dispositivo_id'] = $_GET['dispositivo_id'];
    }

    if (!empty($_GET['data_inicio']) && !empty($_GET['data_fim'])) {
        $filters['data_hora'] = ['between', $_GET['data_inicio'], $_GET['data_fim']];
    }

    return $filters;
}
