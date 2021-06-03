<?php
// require("../database/cenexao.php");
require("../../database/conexao.php");
session_start();

if (!isset($_SESSION['id'])) {
  //verificado se o usuario logou, caso não tenha, ele é redirecioando para a index com uma mensagem de erro 
  $_SESSION['mensagem'] = "Acesso negado, você precisa logar.";

  header("location: ../index.php");
}
$sqlSlect = "SELECT * FROM tbl_categoria";
$resultado = mysqli_query($conexao, $sqlSlect) or die(mysqli_error($conexao));
// $registro = mysqli_fetch_array($resultado);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../styles-global.css" />
  <link rel="stylesheet" href="./novo.css" />
  <title>Administrar Produtos</title>
</head>

<body>
  <!-- <header>
    <input type="search" placeholder="Pesquisar" />
  </header> -->
  <?php
  include("../../componentes/header/header.php");
  ?>
  <div class="content">
    <section class="produtos-container">
      <main>
        <form class="form-produto" method="POST" action="./acaoNovoProdutos.php" enctype="multipart/form-data">
          <input type="hidden" value="inserir" name="acao" />
          <h1>Cadastro de produto</h1>
          <ul>
            <?php
            //verifica se existe erros na sessão do usuario
            if (isset($_SESSION['erros'])) {
              $erros = $_SESSION['erros'];
              foreach ($erros as $erro) {
            ?>
                <li><?= $erro ?></li>
            <?php
              }
              //eliminar da sessão os erros ja mostrado
              unset($_SESSION['erros']);
            }
            ?>
          </ul>
          <div class="input-group span2">
            <label for="descricao">Descrição</label>
            <input type="text" id="descricao" required value="" name="descricao">
          </div>
          <div class="input-group">
            <label for="peso">Peso</label>
            <input type="text" id="peso" required value="" name="peso">
          </div>
          <div class="input-group">
            <label for="quantidade">Quantidade</label>
            <input type="text" id="quantidade" required value="" name="quantidade">
          </div>
          <div class="input-group">
            <label for="cor">Cor</label>
            <input type="text" id="cor" required value="" name="cor">
          </div>
          <div class="input-group">
            <label for="tamanho">Tamanho</label>
            <input type="text" id="tamanho" value="" name="tamanho">
          </div>
          <div class="input-group">
            <label for="valor">Valor</label>
            <input type="text" id="valor" required value="" name="valor">
          </div>
          <div class="input-group">
            <label for="desconto">Desconto</label>
            <input type="text" id="desconto" value="" name="desconto">
          </div>
          <div class="input-group">
            <label for="categoria">Categoria</label>
            <select name="categoria" id="categoria">
              <option readme>
                Selecione uma Categoria
              </option>
              <?php
              while ($registro = mysqli_fetch_array($resultado)) {

              ?>
                <option value="<?= $registro['id'] ?>">
                  <?= $registro['descricao'] ?>
                </option>
              <?php
              }

              ?>
            </select>
          </div>
          <div class="input-group">
            <label for="input-file">Foto</label>

            <input type="file" id="input-file" name="foto" accept="image/*" required>
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