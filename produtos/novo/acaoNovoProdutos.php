<?php
require("../../database/conexao.php");

session_start();




//DESAFIO CRIAR UMA FUNÇÃO QUE VALIDE O FORMULÁRIO.

//!isset  significa "se não", se não esta setado

function validarCampos()
{
    $erros = [];

    // var_dump($_FILES);

    // exit();

    //validar se o campo descricao esta setado
    if (!isset($_POST['descricao']) && $_POST['descricao'] == "") {
        $erros[] = "O campo descricao é obrigatório";
    }

    //validar se o campo quantidade esta setado
    if (!isset($_POST['quantidade']) && $_POST['quantidade'] == "") {
        $erros[] = "O campo quantidade é obrigatório";
    } elseif (isset($_POST['quantidade']) && $_POST['quantidade'] != "" && !is_numeric(str_replace(",", ".", $_POST['quantidade']))) {
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
    } elseif (isset($_POST['valor']) && $_POST['valor'] != "" && !is_numeric(str_replace(",", ".", $_POST['valor']))) {
        //validar se o campo valor é um numero  
        $erros[] = "O campo valor deve ser um numero";
    }


    //Validar se o campo peso esta preenchido
    if (!isset($_POST['peso']) && $_POST['peso'] == "") {
        $erros[] = "O campo peso é obrigatório";
    } elseif (!is_numeric(str_replace(",", ".", $_POST['peso']))) {
        //validar se o campo peso é um numero   
        $erros[] = "O campo peso deve ser um numero";
    }

    //validar se o campo desconto é um numero  
    if (isset($_POST['desconto']) && $_POST['desconto'] != "" && !is_numeric(str_replace(",", ".", $_POST['desconto']))) {
        $erros[] = "O campo desconto deve ser um numero";
    }

    // Fazer o upload de imagem no iCatalago.
    if ($_FILES['foto']['error'] == UPLOAD_ERR_NO_FILE) {
        $erros[] = "O Campo imagem é obrigatorio";
    } else if (!isset($_FILES['foto']) || $_FILES['foto']['error'] != UPLOAD_ERR_OK) {
        $erros[] = "Ops!, houve um erro inesperado, verifique o arquivo e tente novamente";
    } else {
        $fotoInfos = getimagesize($_FILES['foto']['tmp_name']);

        if (!$fotoInfos) {
            $erros[] = "o arquivo precisa ser uma foto";
        }

        // A imagem não pode ser maior que 3MB
        if ($_FILES['foto']['size'] > 1024 * 1024 * 2) {
            $erros[] = "O arquivo não pode ser maior que 2 MB";
        }

        $width = $fotoInfos[0];
        $heigth = $fotoInfos[1];
        if ($width != $heigth) {
            $erros[] = "A imagem precisa ser quadrada";
        }
    }

    //validar o campo categoria (obrigatório)
    if (!isset($_POST['categoria']) || $_POST['categoria'] == "") {
        $erros[] = "O campo categoria é obrigatorio";
    }

    return $erros;
}
/*
    
    incluir a categoria no insert
*/




$erros = validarCampos();

if (count($erros) > 0) {
    $_SESSION["erros"] = $erros;

    header("location: index.php");

    exit();
}

switch ($_POST['acao']) {
    case 'inserir':
        //foto
        $nomeArquivo = $_FILES['foto']['name'];
        $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);
        $novoNomeArquivo = md5(microtime()) . ".$extensao";
        // Depois de salvar a imagem, guardar no banco de dados o nome.
        move_uploaded_file($_FILES['foto']['tmp_name'], "../imagensProdutos/$novoNomeArquivo");

        $descricao = $_POST['descricao'];
        $peso = str_replace(",", ".", $_POST['peso']); //precisamos trocar a virgula do decimal por ponto atravez do srt_replace
        $quantidade = $_POST['quantidade'];
        $cor = $_POST['cor'];
        $tamanho = $_POST['tamanho'];
        $valor = str_replace(",", ".", $_POST['valor']);
        $desconto = $_POST['desconto'] != "" ? $_POST['desconto'] : 0;
        $imagem = $novoNomeArquivo;

        //receber o id da categoria selecionada
        $categoriaId = $_POST['categoria'];

        $sqlInsert = "INSERT INTO tbl_produto (descricao, peso, quantidade, cor, tamanho, valor, desconto, imagem, categoria_id) 
        VALUES ('$descricao', $peso, $quantidade, '$cor', '$tamanho', $valor, '$desconto', '$imagem', $categoriaId);";
        $resultado = mysqli_query($conexao, $sqlInsert) or die(mysqli_error($conexao));

        if ($resultado) {
            $mensagem = "Produto inserido com sucesso";
        } else {
            $mensagem = "Erro ao inserir imagem";
        }

        $_SESSION['mensagem'] = $mensagem;

        //então damos um ../ para voltar uma pasta
        //o ./ (um ponto) não volta a pasta, mas sim continua na mesma
        header("location: ../index.php");
        break;
    case 'deletar':

        break;

    default:
        # code...
        break;
}
// //foto
// $nomeArquivo = $_FILES['foto']['name'];
// $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);
// $novoNomeArquivo = md5(microtime()) . ".$extensao";
// // Depois de salvar a imagem, guardar no banco de dados o nome.
// move_uploaded_file($_FILES['foto']['tmp_name'], "../imagensProdutos/$novoNomeArquivo");

// $descricao = $_POST['descricao'];
// $peso = str_replace(",", ".", $_POST['peso']); //precisamos trocar a virgula do decimal por ponto atravez do srt_replace
// $quantidade = $_POST['quantidade'];
// $cor = $_POST['cor'];
// $tamanho = $_POST['tamanho'];
// $valor = str_replace(",", ".", $_POST['valor']);
// $desconto = $_POST['desconto'] != "" ? $_POST['desconto'] : 0;
// $imagem = $novoNomeArquivo;

// //receber o id da categoria selecionada
// $categoriaId = $_POST['categoria'];

// $sqlInsert = "INSERT INTO tbl_produto (descricao, peso, quantidade, cor, tamanho, valor, desconto, imagem, categoria_id) 
//         VALUES ('$descricao', $peso, $quantidade, '$cor', '$tamanho', $valor, '$desconto', '$imagem', $categoriaId);";
// $resultado = mysqli_query($conexao, $sqlInsert) or die(mysqli_error($conexao));

// if ($resultado) {
//     $mensagem = "Produto inserido com sucesso";
// } else {
//     $mensagem = "Erro ao inserir imagem";
// }

// $_SESSION['mensagem'] = $mensagem;

// //então damos um ../ para voltar uma pasta
// //o ./ (um ponto) não volta a pasta, mas sim continua na mesma
// header("location: ../index.php");
