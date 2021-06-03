<?php
// Fazer a inclusão, listagem e deleção de categorias.
session_start();
require("../database/conexao.php");

function validaCampos(){
    $erros = [];

    if(!isset($_POST['descricao']) || $_POST['descricao'] == ''){
        $erros[] = "O campo descricao é obrigatorio";
    }

    return $erros;
}

switch ($_POST['acao']) {
    case 'inserir':

        $erros = validaCampos();

        if(count($erros) > 0){
            $_SESSION['mensagem'] = $erros[0];

            header("location: ./index.php");

            exit();
        }

        if(isset($_POST['descricao'])){
            $desricao = $_POST['descricao'];
        }else{
            $mensagem = "insira uma descrição";
            $_SESSION['mensagem'] = $mensagem;
        }
        $sql = "INSERT INTO tbl_categoria (descricao) VALUE ('$desricao')";
        $resultado = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
        $registro = mysqli_fetch_array($resultado);
        $desricoes = $registro['descricao'];
        $_SESSION['descricoes'] = $desricoes;

        if($resultado){
            $_SESSION['mensagem'] = "Categoria incluída com sucesso";
        }else{
            $_SESSION['mensagem'] = "Erro ao incluir categoria";
        }

        header("./index.php");
    break;
    case 'deletar':
    
        if (isset($_POST["categoriaId"])) {
            $categoriaId = $_POST['categoriaId'];
            $sqlDelete = "DELETE FROM tbl_categoria WHERE id= $categoriaId;";
            $resultado = mysqli_query($conexao, $sqlDelete);

            if($resultado){
                $mensagem = "Tarefa excluída com sucesso!";
                $tipoMensagem = "sucesso";
            }else{
                $mensagem = "Erro ao excluir a tarefa!";
                
            }

        }

        if($resultado){
            $_SESSION['mensagem'] = "Categoria excluida com sucesso";
        }else{
            $_SESSION['mensagem'] = "Ops!, erro ao excluir categoria";
        }

        break;
    default:
        # code...
        break;
}

header("location: ./index.php");