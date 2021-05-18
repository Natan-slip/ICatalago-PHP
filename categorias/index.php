<?php

session_start();

require("../database/conexao.php");

$sql = "SELECT * FROM tbl_categoria" ;
$resultado = mysqli_query($conexao,$sql);

?>

?>
<!DOCTYPE html>
<html lang="pt-br">

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
    include("../componentes/header/header.php");
    ?>
    <div class="content">
        <section class="categorias-container">
            <main>
                <form class="form-categorias" method="POST" action="./acoesCategoria.php">
                    <h1 class="span2">Adicionar Categorias</h1>
                    <div class="input-group span2">
                        <label for="descricao">Descricao</label>
                        <input type="hidden" name="acao" value="inserir" />
                        <input type="text" name="descricao" id="descricao" />
                    </div>
                    <button type="button" onclick="">Cancelar</button>
                    <button>Salvar</button>
                </form>
                <h1>Lista de categorias</h1>
                
                <?php
                    while($categoria = mysqli_fetch_array($resultado)){
                ?>
                    <div class="card-categorias">
                        <?= $categoria['descricao'] ?>
                        <img src="https://icons.veryicon.com/png/o/construction-tools/coca-design/delete-189.png" />
                    </div> 
                <?php
                    }
                ?>
            </main>
        </section>
    </div>
</body>

</html>