<?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    require_once 'db.php';
    require_once 'GerenciadorMensagem.php';

    function sanitizarEntrada($dado, $tipo = 'string'){
        if ($tipo == 'string'){
            return htmlspecialchars(trim($dado),ENT_QUOTES,'UTF-8');
        } else if ($tipo == 'inteiro'){
            return filter_var($dado,FILTER_SANITIZE_NUMBER_INT);
        } else if ($tipo == 'real'){
            return $filver_var($dado, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        }
        return $dado;
    }

    function obterDados($nomeTabela, $criterios = [], $colunas = '*', $ordem = '', $limite = null){
        try {
            $conexao = conectarBD();
            $pagina = '../public/index.php';
    
            if (!$conexao) {
                throw new Exception("Falha na conexão com o banco de dados");
            }
    
            // Monta a consulta SQL dinamicamente
            $consulta = "SELECT $colunas
                        FROM $nomeTabela";
    
            // Adiciona critérios de filtro (WHERE) dinamicamente
            if (!empty($criterios)) {
                $condicoes = [];
                foreach ($criterios as $coluna => $valor) {
                    if (is_array($valor) && $valor[0] === 'between') {
                        $condicoes[] = "$coluna BETWEEN :${coluna}_inicio AND :${coluna}_fim";
                    } else {
                        $condicoes[] = "$coluna = :$coluna";
                    }
                }
                $consulta .= " WHERE " . implode(' AND ', $condicoes);
            }
    
            // Adiciona ordenação, se especificado
            if (!empty($ordem)) {
                $consulta .= " ORDER BY $ordem";
            }
    
            // Adiciona limite, se especificado
            if ($limite) {
                $consulta .= " LIMIT $limite";
            }
    
            $stmt = $conexao->prepare($consulta);
    
            // Associa os valores dos critérios ao prepared statement
            foreach ($criterios as $coluna => $valor) {
                if (is_array($valor) && $valor[0] === 'between') {
                    // Converte as datas para o formato do banco de dados e adiciona o horário
                    $dataInicio = $valor[1] . ' 00:00:00';
                    $dataFim = $valor[2] . ' 23:59:59';
                    
                    $stmt->bindValue(":{$coluna}_inicio", $dataInicio);
                    $stmt->bindValue(":{$coluna}_fim", $dataFim);
                } else {
                    $stmt->bindValue(":$coluna", $valor);
                }
            }
    
            if (!$stmt->execute()) {
                throw new Exception("Erro ao executar a consulta");
            }
    
            $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $dados;
            
        } catch (Exception $e){
            GerenciadorMensagem::tratarErro($e, $pagina);
        } finally {
            $conexao = null;
        }
    }

function cadastrarItem($tabela, $dados, $secaoId){
    try {
        
        $conexao = conectarBD();
       

        if (!$conexao) {
            throw new Exception("Falha na conexão com o banco de dados");
        }

        $colunas = implode(", ", array_keys($dados));
        $placeholders = ":" . implode(", :", array_keys($dados));

        $sql = "INSERT INTO $tabela ($colunas) VALUES ($placeholders)";
        $stmt = $conexao->prepare($sql);

        if ($stmt->execute($dados)) {
            GerenciadorMensagem::definirMensagem('Item cadastrado com sucesso!','sucesso',$pagina);
        } else {
            throw new Exception("Erro ao cadastrar o item.");
        }
        
    } catch (Exception $e){
        GerenciadorMensagem::tratarErro($e, $pagina);
    }
}

function verificarFiltros(){
    $filtros = [];

    if (!empty($_GET['setor_id'])){
        $filtros['setor_id'] = $_GET['setor_id'];
    }

    if (!empty($_GET['pergunta_id'])){
        $filtros['pergunta_id'] = $_GET['pergunta_id'];
    }

    if (!empty($_GET['dispositivo_id'])){
        $filtros['dispositivo_id'] = $_GET['dispositivo_id'];
    }

    if (!empty($_GET['data_inicio']) && !empty($_GET['data_fim'])){
        $filtros['data_hora'] = ['between', $_GET['data_inicio'], $_GET['data_fim']];
    }

    return $filtros;

}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['formulario'])) {
    $formulario = $_POST ['formulario']; 

    $dados = [];
    $tabela = '';
    $secaoId = '';

    switch($formulario){

        case 'perguntas':
            $tabela = 'PERGUNTAS';
            $secaoId = 'perguntas';
            $dados = [
                'texto' =>sanitizarEntrada($_POST['texto'],'string'),
                'ordem' =>sanitizarEntrada($_POST['ordem'],'inteiro'),
                'status' => TRUE
            ];
        break;  
        
        case 'setores':
            $tabela = 'setores';
            $secaoId = 'setores';
            $dados = [
                'nome' => sanitizarEntrada($_POST['nome'],'string')
            ];
        break;
        
        case 'dispositivos':
            $tabela = 'dispositivos';
            $secaoId = 'dispositivos';
            $dados = [
                'nome' => sanitizarEntrada($_POST['nome'],'string')
            ];
        break;

        
            return;
            
    }

    cadastrarItem($tabela, $dados, $secaoId);
    
}


if (isset($_GET['desativar']) && isset($_GET['tabela'])&& isset($_GET['secaoId'])) {
            
    try {

        $id = (int)$_GET['desativar'];
        $secaoId = $_GET['secaoId'];
        $tabela = $_GET['tabela'];
        
        $conexao = conectarBD();
        

        if (!$conexao) {
            throw new Exception("Falha na conexão com o banco de dados");
        }

        $query = "UPDATE $tabela
                     SET status = NOT STATUS
                   WHERE id = :id";
                   
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            GerenciadorMensagem::definirMensagem('Status do registro alterado com sucesso!','sucesso',$pagina);
        } else {
            throw new Exception("Erro ao alterar o status do registro.");
        }
    } catch (Exception $e){
        GerenciadorMensagem::tratarErro($e, $pagina);
    } finally{
        $conexao = null;
    }
}

if (isset($_GET['remover']) && isset($_GET['tabela'])&& isset($_GET['secaoId'])) {
            
    try {

        $id = (int)$_GET['remover'];
        $secaoId = $_GET['secaoId'];
        $tabela = $_GET['tabela'];
        
        
        $conexao = conectarBD();

        if (!$conexao) {
            throw new Exception("Falha na conexão com o banco de dados");
        }

        $query = "DELETE FROM $tabela
                   WHERE id = :id";
                   
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            GerenciadorMensagem::definirMensagem('Registro removido com sucesso!','sucesso',$pagina);
        } else {
            throw new Exception("Erro ao remover o registro.");
        }
    } catch (Exception $e){
        GerenciadorMensagem::tratarErro($e, $pagina);
    } finally{
        $conexao = null;
    }
}