<?php
session_start();
require("../database/conexao.php");


    // Criar a tabela de categorias. FEITO

    // Fazer a inclusão, listagem e deleção de categorias. FEITO
    

    // Proteger a página de categorias caso o usuário não estiver logado. FEITO
    if(!isset($_SESSION['id'])){
        //verificado se o usuario logou, caso não tenha, ele é redirecioando para a index com uma mensagem de erro 
        $_SESSION['mensagem'] = "Acesso negado, você precisa logar.";
    
        header("location: ../produtos/index.php");
    }

    // DESAFIO: Na página de novo produto, fazer um <select> listando as categorias. FAZER
  
$sqlSlect = "SELECT * FROM tbl_categoria";
$resultado = mysqli_query($conexao, $sqlSlect) or die(mysqli_error($conexao));
$registros = mysqli_fetch_array($resultado);

// $_SESSION['registroCategoria'] = $registros['descricao'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles-global.css" />
    <link rel="stylesheet" href="./categorias.css" />
    <title>Administrar Categorias</title>
</head>

<body>
    <?php
    require("../componentes/header/header.php");
    ?>
    <div class="content">
        <section class="categorias-container">
            <main>
                <form class="form-categorias" action="./acoes_categoria.php" method="POST">
                    <h1 class="span2">Adicionar Categorias</h1>
                    <div class="input-group span2">
                        <label for="descricao">Descricao</label>
                        <input type="hidden" name="acao" value="inserir" />
                        <input type="text" name="descricao" id="descricao" required />
                    </div>
                    <button type="button" onclick="javascript: window.location.href='../produtos/index.php'">Cancelar</button>
                    <button>Salvar</button>
                </form>
                <h1>Lista de categorias</h1>

                <?php
                    while($registro = mysqli_fetch_array($resultado)){
                            // foreach ($registros as $registro) {
                ?>
                    <div class="card-categorias">
                        <?= $registro['descricao'] ?>
                        <!-- <img onclick="excluir(<?= $registro['id'] ?>)"  src="https://icons.veryicon.com/png/o/construction-tools/coca-design/delete-189.png" /> -->
                        <form action="./acoes_categoria.php" method="POST" id="form__excluir">
                            <input type="hidden" id="deletar" name="acao" value="deletar" />
                            <input type="hidden" id="categoriaId" name="categoriaId" value="<?= $registro['id'] ?>" />
                            <button id="btn_lixeira">&#128465;</button>
                        </form>
                    </div> 
                <?php
                    }
                ?>
                <!-- Deleção atraves de javascript -->
                <!-- <form id="form-deletar" action="./acoes_categoria.php" method="POST">
                    <input type="hidden" value="deletar" name="acao">
                    <input type="hidden" id="categoriaId" name="categoriaId" value="<?= $registro['id'] ?>">
                </form> -->
                <!-- teste com o foreach -->
                
            </main>
        </section>
    </div>
    <script lang="javascript">
        function excluir(categoriaId){
            document.querySelector('#categoriaId').value = categoriaId;
            document.querySelector('#form-deletar').submit();
        }
    </script>
</body>

</html>