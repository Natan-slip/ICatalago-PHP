<?php

session_start();
require("../database/conexao.php");

function validaCampos()
{
    $erros = [];
    if (!isset($_POST["descricao"]) || $_POST["descricao"] == "") {
        $erros[] = "O campo descrição é obrigatório";
    }
    return $erros;
}

switch ($_POST["acao"]) {

    case "inserir":

        $erros = validaCampos();
        if (count($erros) > 0) {
            $_SESSION["erros"] = $erros;
            header("location: index.php");

            exit();
        }
        //receber os campos do formulário
        $descricao = $_POST["descricao"];
        //montar o sql de insert
        $sql = " INSERT INTO tbl_categoria (descricao) VALUES ('$descricao') ";
        //executar o sql de insert
        $resultado = mysqli_query($conexao, $sql);
        //verificar se deu certo
        if ($resultado) {
            $_SESSION["mensagem"] = "Categoria inserida com sucesso";
        } else {
            $_SESSION["mensagem"] = "Opa, acho que houve algum erro";
        }
        //redirecionar para tela de categorias com uma mensagem
        header("location: index.php");

        break;

    case "deletar":

        $categoriaId = $_POST["categoriaId"];

        $sqlDelecao = "DELETE FROM tbl_categoria WHERE id = $categoriaId";

        $resultado = mysqli_query($conexao, $sql);

        if ($resultado) {
            $_SESSION["mensagem"] = "Categoria deletada";
        }
        else {
            $_SESSION["mensagem"] = "Erro ao excluir";
        }

        header("location: ./index.php");
    break;
}