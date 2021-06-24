<?php
session_start();

require("../../database/conexao.php");

$produtoId = $_GET["id"];

$sqlProduto = "SELECT * FROM tbl_produto WHERE id = $produtoId ";

$resultado = mysqli_query($conexao, $sqlProduto);

$produto = mysqli_fetch_array($resultado);

if(!$produto){
  echo "Ops, este produto não existe, acesso negado!";

  exit();
}

$sql = " SELECT * FROM tbl_categoria ";

$resultado = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../styles-global.css" />
  <link rel="stylesheet" href="./editar.css" />
  <title>Editar Produtos</title>
</head>

<body>
  <?php
  include("../../componentes/header/header.php");

  if (!isset($_SESSION["usuarioId"])) {

    //redireciona para a página de produtos com mensagem de erro
    $_SESSION["mensagem"] = "Você precisa fazer login para acessar essa página.";

    header("location: ../index.php");
  }
  ?>
  <div class="content">
    <section class="produtos-container">
      <main>
        <form class="form-produto" method="POST" action="../acoes.php" enctype="multipart/form-data">
          <input type="hidden" name="acao" value="editar" />
          <input type="hidden" name="produtoId" value="<?= $produto["id"] ?>" />
          <h1>Editar produto</h1>
          <ul>
            <?php
            //verifica se existe erros na sessão do usuário
            if (isset($_SESSION["erros"])) {
              //se existir percorre os erros exbindo na tela
              foreach ($_SESSION["erros"] as $erro) {
            ?>
                <li><?= $erro ?></li>
            <?php
              }
              //eliminar da sessão os erros já mostrados
              unset($_SESSION["erros"]);
            }
            ?>
          </ul>
          <div class="input-group span2">
            <label for="descricao">Descrição</label>
            <input type="text" name="descricao" id="descricao" value="<?= $produto["descricao"] ?>" required>
          </div>
          <div class="input-group">
            <label for="peso">Peso</label>
            <input type="text" name="peso" id="peso" value="<?= $produto["peso"] ?>" required>
          </div>
          <div class="input-group">
            <label for="quantidade">Quantidade</label>
            <input type="text" name="quantidade" id="quantidade" value="<?= $produto["quantidade"] ?>" required>
          </div>
          <div class="input-group">
            <label for="cor">Cor</label>
            <input type="text" name="cor" id="cor" value="<?= $produto["cor"] ?>" required>
          </div>
          <div class="input-group">
            <label for="tamanho">Tamanho</label>
            <input type="text" name="tamanho" id="tamanho" value="<?= $produto["tamanho"] ?>">
          </div>
          <div class="input-group">
            <label for="valor">Valor</label>
            <input type="text" name="valor" id="valor" value="<?= number_format($produto["valor"], 2, ",", ".") ?>" required>
          </div>
          <div class="input-group">
            <label for="desconto">Desconto</label>
            <input type="text" name="desconto" id="desconto" value="<?= $produto["desconto"] ?>">
          </div>
          <div class="input-group">
            <label for="categoria">Categoria</label>
            <select id="categoria" name="categoria" required>
              <option value="">SELECIONE</option>
              <?php
              while ($categoria = mysqli_fetch_array($resultado)) {
              ?>
                <option value="<?= $categoria["id"] ?>" <?= $categoria["id"] == $produto["categoria_id"] ? "selected" : "" ?>>
                <?= $categoria["descricao"] ?>
                </option>
                
              <?php
              }
              ?>
            </select>
          </div>
          <div class="input-group">
            <label for="categoria">Foto</label>
            <input type="file" name="foto" id="foto" accept="image/*" />
          </div>
          <button onclick="javascript:window.location.href = '../'">Cancelar</button>
          <button>Salvar</button>
        </form>
      </main>
    </section>
  </div>
  <footer>
    SENAI 2021 - Todos os direitos reservados
  </footer>
</body>

</html>