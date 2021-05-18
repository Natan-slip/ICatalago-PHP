<?php

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
                    <input type="hidden" name="acao" value="inserir">
                    <h1 class="span2">Adicionar Categorias</h1>
                    <ul>
                        <?php
                            if(isset($_SESSION["erros"])){
                                foreach ($_SESSION["erros"] as $erros) {
                        ?>
                                <li><?= $erro ?></li>
                                    
                        <?php
                            }            
                            
                        }
                        ?>
                    </ul>
                    <div class="input-group span2">
                        <label for="descricao">Descricao</label>
                        <input type="text" name="descricao" id="descricao" />
                    </div>
                    <button type="button" onclick="javascript:window.location.href = '../produtos'">Cancelar</button>
                    <button>Salvar</button>
                </form>
                <h1>Lista de categorias</h1>
                <?php

                    if(mysqli_num_rows($resultado) == 0){
                        echo "<p style='text-align: center'>Nenhuma categoria cadastrada.</p>";
                    }

                    while($categoria = mysqli_fetch_array($resultado)) {
                
                ?>
                    <div class="card-categorias">
                        <?= $categoria["descricao"] ?>
                        <img onclick="deletar(<?= $categoria['id'] ?>)" src="https://icons.veryicon.com/png/o/construction-tools/coca-design/delete-189.png" />
                    </div> 
                <?php
                    }
                ?>
                <form id="form-deletar" method="POST" action="./acoesCategoria.php">
                    <input type="hidden" name="aco" value="deletar" />
                    <input type="hidden" id="categoriaId" name="categoriaId" value="" />
                </form>
            </main>
        </section>
    </div>
    <script lang="javascript">
        function deletar(categoriaId){
            document.querySelector("#categoriaId").value = categoriaId;
            document.querySelector("#form-deletar").submit();
        }
    </script>    
</body>

</html>