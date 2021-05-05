<?php

     require("../../database/conexao.php");


     if(isset($_POST['descricao']) && isset($_POST['peso']) && isset($_POST['quantidade']) && isset($_POST['cor'])
     && isset($_POST['tamanho']) && isset($_POST['valor']) && isset($_POST['desconto']) ){

      $descricao = $_POST['descricao'];
      //precisamos trocar a virgula do decimal por ponto
      $peso = str_replace(",", ".", $_POST['peso']);
      $quantidade = $_POST['quantidade'];
      $cor = $_POST['cor'];
      $tamanho = $_POST['tamanho'];
      $valor = str_replace(",", ".", $_POST['valor']);
      $desconto = $_POST['desconto'] != "" ? $_POST['desconto'] : 0;

        $sqlInsert = "INSERT INTO tbl_produto (descricao, peso, quantidade, cor, tamanho, valor, desconto) 
        VALUES ('$descricao', $peso, $quantidade, '$cor', '$tamanho', $valor, '$desconto');";

        $resultado = mysqli_query($conexao, $sqlInsert) or die(mysqli_error($conexao));
    }

    header ("location: index.php");

    session_start();

    function validarCampos(){
      $erros = [];

      //validar se o campo descricao esta setado
      if (!isset($_POST['descricao']) && $_POST['descricao'] == "") {
          $erros[] = "O campo descricao é obrigatório";
      }

      //validar se o campo quantidade esta setado
      if (!isset($_POST['quantidade']) && $_POST['quantidade'] == "") {
          $erros[] = "O campo quantidade é obrigatório";
      }elseif(isset($_POST['quantidade']) && $_POST['quantidade'] != "" && !is_numeric(str_replace(",", ".", $_POST['quantidade']))){
          //validar se o campo quantidade é um numero  
          $erros[] = "O campo quantidade deve ser um numero";
      }

      //validar se o campo cor esta setado
      if (!isset($_POST['cor']) && $_POST['cor'] == "") {
          $erros[] = "O campo cor é obrigatório";
      }

      //validar se o campo valor esta setado 
      if (!isset($_POST['valor']) && $_POST['valor'] == "") {
          $erros[] = "O campo valor é obrigatório";
      }elseif(isset($_POST['valor']) && $_POST['valor'] != "" && !is_numeric(str_replace(",", ".", $_POST['valor']))){
          //validar se o campo valor é um numero  
          $erros[] = "O campo valor deve ser um numero";
      }


      //Validar se o campo peso esta preenchido
      if(!isset($_POST['peso']) && $_POST['peso'] == ""){
          $erros[] = "O campo peso é obrigatório";
      }elseif(!is_numeric(str_replace(",", ".", $_POST['peso']))){
                  //validar se o campo peso é um numero   
          $erros[] = "O campo peso deve ser um numero";
      }

      //validar se o campo desconto é um numero  
      if(isset($_POST['desconto']) && $_POST['desconto'] != "" && !is_numeric(str_replace(",", ".", $_POST['desconto']))){
          $erros[] = "O campo desconto deve ser um numero";
      }

      return $erros;
  }

  $erros = validarCampos();

  if (count($erros) > 0){
      $_SESSION["erros"] = $erros;

      header("location: ../produtos/novo/index.php?erros=$erros");
  }

  ?>  