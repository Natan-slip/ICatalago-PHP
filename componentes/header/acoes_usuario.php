<?php

require("../../database/conexao.php");

session_start();

function validarCampos(){
    $erros = [];
    if(!isset($_POST['usuario']) || $_POST['usuario'] ==""){
        $erros[] = "O campo usuario é obrigatorio";
    }
    if(!isset($_POST['senha']) || $_POST['senha'] ==""){
        $erros[] = "O campo senha é obrigatorio";
    }

    return $erros;
}

switch ($_POST['acao']) {
    case "login":

        $erros = validarCampos();

        if(count($erros) > 0){
            $_SESSION['erros'] = $erros;

            header("location: ../../produtos/index.php");
        }

        //receber os campos usuário e senha do post
        if(isset($_POST['usuario']) && isset($_POST['senha'])){
            $usuario = $_POST['usuario'];
            $senha = $_POST['senha'];
        }
        //montar o sql select na tabela tbl_administrador
                    //SELECT * FROM tbl_administrador WHERE usuario = $usuario;
        $sql = "SELECT * FROM tbl_administrador WHERE usuario = '$usuario'";
        //executar o sql
        $resultado = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
        $registro = mysqli_fetch_array($resultado);
        //verificar se o usuário existe
        //verificar se a senha está correta
        //se estiver correta, salvar o id e o nome do usuário na sessão $_SESSION
        //se a senha estiver errada, criar uma mensagem de "usuário e/ou senha inválidos"
        //se estiver correta, salvar o id e o nome do usuário na sessão $_SESSION
        if($usuario == $registro['usuario'] && password_verify($senha, $registro['senha'])){
            $_SESSION['id'] = $registro['id'];
            $_SESSION['nome'] = $registro['nome'];

            $mensagem = "Bem vindo, " . $registro['nome'];
        }else{
            // die("usuario e/ou senha estão incorretos");

            // $mensagem_erro_login = "Usuario e/ou senha estão incorretos";
            // $_SESSION['msg_erro_lgn'] = $mensagem_erro_login;
            $mensagem = "Usuário e/ou senha senha inválidos";
        }
        
        $_SESSION['mensagem'] = $mensagem;
        //redirecionar para a tela de listagem de produtos
        header("location: ../../produtos/index.php");
        
            break;
        
    case "logout":
        //implementar futuramente
        // implementar a ação de login
        // mostrar os botões de adicionar produto e categoria somente se estiver logado (FEITO)

        // implementar o logout (FEITO)
        // logout = limpar a sessão (FEITO)
        session_destroy();
        header("location: ../../produtos/index.php");
        break;
}
?>