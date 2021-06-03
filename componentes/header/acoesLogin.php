<?php
session_start();
require("../../database/conexao.php");

function validarCampos()
{
    $erros = [];

    if (!isset($_POST["usuario"]) && $_POST["usuario"] == "") {
        $erros = "O campo usuário é obrigatório";
    }

    if (!isset($_POST["senha"]) && $_POST["senha"] == "") {
        $erros = "O campo senha é obrigatório";
    }

    return $erros;
}

//autenticação
switch ($_POST["acao"]) {
    case "login":

        $erros = validarCampos();

        if (count($erros) > 0) {
            $_SESSION["mensagens"] = $erros;

            header("location: ../../produtos/index.php");
        }

        //receber os campos do fomulário
        $usuario = $_POST["usuario"];
        $senha = $_POST["senha"];

        //montar o sql select na tabela tbl_adminitrador
        //SELECT * FROM tbl_administrador WHERE usuario = $usuario;
        $sql = " SELECT * FROM tbl_administrador WHERE usuario = '$usuario' ";

        //executar o sql
        $resultado = mysqli_query($conexao, $sql);

        $usuario = mysqli_fetch_array($resultado);

        var_dump($usuario);

        //verificar se o usuário existe e se a senha está correta
        if (!$usuario || !password_verify($senha, $usuario["senha"])) {
            $erros[] = "Usuário e/ou senha inválidos";

            $_SESSION["erros"] = $erros;
        } else {
            //se estiver correta, salvar o id e o nome do usuário na sessão
            $_SESSION["usuarioId"] = $usuario["id"];
            $_SESSION["usuarioNome"] = $usuario["nome"];

            $_SESSION["mensagem"] = "Bem vindo, " . $usuario["nome"];
        }

        //redirecionar para tela de listagem de produtos
        header("location: ../../produtos/index.php");

        break;

    case "logout":
        //implementar o logout
        session_destroy();

        header("location: ../../produtos/index.php");

        break;
}
