<?php

require("../database/conexao.php");

$pesquisa = isset($_GET["p"]) ? $_GET["p"] : null;

if ($pesquisa) {
    $sql = "SELECT p.*, c.descricao as categoria FROM tbl_produto p
    INNER JOIN tbl_categoria c ON p.categoria_id = c.id
    WHERE p.descricao LIKE '%$pesquisa%'
    OR c.descricao LIKE '%$pesquisa%'
    ORDER BY p.id DESC";
} else {
    $sql = " SELECT p.*, c.descricao as categoria FROM tbl_produto p
    INNER JOIN tbl_categoria c ON p.categoria_id = c.id
    ORDER BY p.id DESC ";
}



$resultado = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));


?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles-global.css" />
    <link rel="stylesheet" href="./produtos.css" />
    <title>Administrar Produtos</title>
</head>

<body>
    <?php
    include("../componentes/header/header.php");
    ?>
    <div class="content">
        <section class="produtos-container">
            <?php
            //autorização

            //se o usuário estiver logado, mostrar os botões
            if (isset($_SESSION["usuarioId"])) {
            ?>
                <header>
                    <button onclick="javascript:window.location.href ='./novo/'">Novo Produto</button>
                    <button onclick="javascript:window.location.href ='../categorias/'">Adicionar Categoria</button>
                </header>
            <?php
            }
            ?>
            <main>
                <?php
                while ($produto = mysqli_fetch_array($resultado)) {
                    $valor = $produto["valor"];
                    $desconto = $produto["desconto"];

                    $valorDesconto = 0;

                    if ($desconto > 0) {
                        $valorDesconto = ($desconto / 100) * $valor;
                    }

                    $qntdParcelas = $valor > 1000 ? 12 : 6;
                    $valorComDesconto = $valor - $valorDesconto;
                    $valorParcela = $valorComDesconto / $qntdParcelas;


                ?>
                    <input type="hidden" name="acao" value="<?php $produto["id"] ?>" />
                    <article class="card-produto">
                        <figure>
                            <img src="fotos/<?= $produto["imagem"] ?>" />
                            <?php

                            ?>

                        </figure>
                        <section>
                            <span class="preco">R$ <?= number_format($produto["valor"], 2, ",", ".") ?> <em><?= $desconto ?>% off</em></span>
                            <span class="parcelamento">ou em <em>10x <?= $qntdParcelas ?>x R$<?= number_format($valorParcela, 2, ",", ".") ?> sem juros</em></span>

                            <span class="descricao">Produto <?= $produto["descricao"] ?> cor <?= $produto["cor"] ?></span>
                            <span class="categoria">
                                <em><?= $produto["categoria"] ?></em>
                            </span>
                            <?php

                            if (isset($_SESSION["usuarioId"])) {

                            ?>
                                <form method="POST" action="acoes.php" id="form-button-deletar">
                                    <input type="hidden" name="acao" value="deletar" />
                                    <input type="hidden" name="produtoId" value="<?= $produto["id"] ?>" />
                                    <button>Deletar</button>
                                </form>
                            <?php
                            }
                            ?>
                        </section>
                        <footer>

                        </footer>
                    </article>
                <?php
                }
                ?>
            </main>
        </section>
    </div>
    <footer>
        SENAI 2021 - Todos os direitos reservados
    </footer>
</body>

</html>