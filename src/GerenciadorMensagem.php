<?php

class GerenciadorMensagem {
    private const TIPOS = ['sucesso', 'erro', 'aviso'];
    
    public static function definirMensagem($texto, $tipo = 'aviso', $pagina) {
        $_SESSION['mensagemSistema'] = [
            'texto' => $texto,
            'tipo' => $tipo,
        ];

        header('Location: ' . $pagina);
        exit();
    }

    public static function exibirMensagem() {
        if (isset($_SESSION['mensagemSistema'])) {
            $mensagem = $_SESSION['mensagemSistema'];
            self::renderizarMensagem($mensagem);
            unset($_SESSION['mensagemSistema']);
        }
    }

    private static function renderizarMensagem($mensagem) {
        $icones = [
            'sucesso' => '✓',
            'erro' => '✕',
            'aviso' => '⚠',
        ];

        $icone = $icones[$mensagem['tipo']];
        echo '<div id="mensagemSistema" class="mensagem-sistema">';
        echo '<span class="icone-mensagem">' . $icone . '</span>';
        echo '<span class="texto-mensagem">' . $mensagem['texto'] . '</span>';
        echo '</div>';
    }

    public static function tratarErro($e, $pagina) {
        if ($e instanceof PDOException) {
            switch ($e->getCode()) {
                case '23503':
                    self::definirMensagem(
                        'A exclusão não pôde ser realizada porque este item está vinculado a outro registro.',
                        'erro',
                        $pagina
                    );
                    break;

                case '23505':
                    self::definirMensagem(
                        'O registro que você está tentando adicionar já existe no sistema.',
                        'erro',
                        $pagina
                    );
                    break;

                default:
                    self::definirMensagem(
                        'Um erro inesperado ocorreu no banco de dados. Tente novamente mais tarde.',
                        'erro',
                        $pagina
                    );
                    error_log('Erro PDO: ' . $e->getMessage());
            }
        } else {
            self::definirMensagem(
                'Não foi possível concluir a ação. Por favor, tente novamente mais tarde.',
                'erro',
                $pagina
            );
            error_log('Erro não tratado: ' . $e->getMessage());
        }

        header('Location: ' . $pagina);
    
