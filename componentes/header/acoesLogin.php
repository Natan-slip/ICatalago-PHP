<?php

session_start();


require("../../database/conexao.php");

function validarCampos(){
    $erros = [];

    if (!isset($_POST['usuario']) && $_POST['usuario'] == "") {
        $erros[] = "O campo usuario é obrigatório";
    }

    if (!isset($_POST['senha']) && $_POST['senha'] == "") {
        $erros[] = "O campo senha é obrigatório";
    }

    return $erros;
}


switch($_POST["acao"]){

    case "login":

        if(isset($_POST['nome']) && isset($_POST['usuario']) && isset($_POST['senha'])){

            $usuario = $_POST['usuario'];
            $senha = $_POST['senha'];

        }    

            $sqlSelect = "SELECT * FROM tbl_administrador WHERE usuario = '$usuario'";

            $resultado = mysqli_query($conexao, $sqlInsert) or die(mysqli_error($conexao));
            $dados = mysqli_fetch_array($resultado);
        
        //receber os campos do fomulário
        //monstar o sql select na tabela tbl_adminitrador
        //SELECT * FROM tbl_adminitrador WHERE usuario = $usuario;
        //$usuario["senha"] -- $senha;
        //verificar se o usuário existe e se a senha está correta
        //se estiver correta, salvar o id e o nome do usuário na sessão
        //redirecionar para tela de listagem de produtos

        if($usuario == $dados['usuario'] && $senha == $dados['senha']){

            $_SESSION['id'] = $dados['id'];
            $_SESSION['nome'] = $dados['nome'];
            
        }
        
        header("location: ../../produtos/index.php");    

        break;


    case "logout":

        //implementar o logout



        break;

}
