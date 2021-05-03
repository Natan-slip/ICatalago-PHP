<?php

     require("../../database/conexao.php");


     if(isset($_POST['descricao']) && isset($_POST['peso']) && isset($_POST['quantidade']) && isset($_POST['cor'])
     && isset($_POST['tamanho']) && isset($_POST['valor']) && isset($_POST['desconto']) ){

        $descricao = $_POST['descricao'];
        $peso = $_POST['peso'];
        $quantidade = $_POST['quantidade'];
        $cor = $_POST['cor'];
        $tamanho = $_POST['tamanho'];
        $valor = $_POST['valor'];
        $desconto = $_POST['desconto'];

        $sqlInsert = "INSERT INTO tbl_produto (descricao, peso, quantidade, cor, tamanho, valor, desconto) 
        VALUES ('$descricao', $peso, $quantidade, '$cor', '$tamanho', $valor, $desconto)";

        $resultado = mysqli_query($conexao, $sqlInsert) or die(mysqli_error($conexao));
    }

    header ("location: index.php");

  ?>  