<?php
session_start();

require("../database/conexao.php");


if (isset($_POST['pesquisa'])) {
    $filtroPesquisa = $_POST['pesquisa'];
    $sql =  "SELECT p.*, c.descricao as categoria FROM tbl_produto p
INNER JOIN tbl_categoria c ON p.categoria_id = c.id
WHERE p.descricao LIKE '%$filtroPesquisa%'
OR c.descricao LIKE '%$filtroPesquisa%'
ORDER BY p.id DESC;";
} else {
    $sql = "SELECT p.*, c.descricao as categoria FROM tbl_produto p
INNER JOIN tbl_categoria c ON p.categoria_id = c.id
ORDER BY p.id DESC;";
}

$resultado = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

$registro = mysqli_fetch_array($resultado);

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
            if (isset($_SESSION['id']) && isset($_SESSION['nome'])) {
            ?>
                <header>
                    <button onclick="javascript:window.location.href ='./novo/'">Novo Produto</button>
                    <button onclick="javascript:window.location.href ='../categorias'">Adicionar Categoria</button>
                </header>
            <?php
            }
            ?>
            <main>
                <!-- <article class="card-produto">
                    <figure>
                        <img src="http://3.bp.blogspot.com/-u34_1MW1w5g/T_eNqYLmtFI/AAAAAAAAEP0/jnssgMNcS8Y/s1600/converse-all-star-dark-blue.png" />
                    </figure>
                    <section>
                        <span class="preco">R$ 1000,00</span>
                        <span class="parcelamento">ou em <em>10x R$100,00 sem juros</em></span>

                        <span class="descricao">Produto xyz cor preta novo perfeito estado 100%</span>
                        <span class="categoria">
                            <em>Calçados</em> <em>Vestuário</em><em>Calçados</em>
                        </span>
                    </section>
                    <footer>
                    </footer>
                </article> -->
                <?php
                foreach ($resultado as $registro) {
                    $qtdParcelas = $registro['valor'] > 1000 ? 12 : 6;
                    $valorParcela = $registro['valor'] / $qtdParcelas;
                    $valorParcela = number_format($valorParcela, 2, ",", '.');

                    //Parcelas
                    $preco = $registro['valor'];
                    $desconto =  $registro['desconto'];
                    $precoDescontado = ($desconto / 100) * $preco;
                    $precoFinalComDesconto = $preco - $precoDescontado;
                ?>
                    <article class="card-produto">
                        <figure>
                            <!-- mostrar a imagem do produto (que veio do banco)- -->
                            <img src="./imagensProdutos/<?= $registro['imagem'] ?>" />
                        </figure>
                        <section>
                            <span class="preco">
                                <!-- mostrar o valor do produto FEITO- -->
                                <!-- DESAFIO2: Implementar o desconto no preço do produto FAZER -->
                                R$ <?php
                                    if ($registro['desconto'] == 0) {
                                    ?>
                                    <?= number_format($precoFinalComDesconto, 2, ",", ".") ?>
                                <?php
                                    } else {
                                ?>
                                    <?= number_format($precoFinalComDesconto, 2, ",", ".") ?>
                                    <em><?= $registro['desconto'] ?> Off</em>
                                <?php
                                    }
                                ?>

                            </span>
                            <span class="parcelamento">ou em <em>
                                    <?php
                                    //DESAFIO: mostrar a opção de parcelamento
                                    //SE O VALOR > 1000, PARCELAR EM ATÉ 12x 
                                    if ($registro['valor'] > 1000) {
                                    ?>
                                        12x R$100,00 sem juros
                                    <?php
                                        //SE NÃO, PARCELAR EM ATÉ 6x
                                    } else {
                                    ?>
                                        6x R$100,00 sem juros
                                    <?php
                                    }
                                    ?>
                                </em></span>

                            <span class="descricao">
                                <!-- mostrar a descricao do produto FEITO- -->
                                <?= $registro['descricao'] ?>
                            </span>

                            <span class="categoria">
                                <!-- mostrar a categoria do produto FEITO-  -->
                                <em><?= $registro['categoria'] ?></em>
                            </span>
                            <span class="spanDelete">
                                <button class="btnDeletar">
                                    &#128465;
                                </button>
                            </span>
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