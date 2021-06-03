<?php
// session_start();
//    include("../../database/conexao.php");

//ALT + SHIFT + F   IDENTA

?>
<link rel="stylesheet" href="/web-backend-a/icatalogo-parte1/componentes/header/header.css">
<?php
if (isset($_SESSION['mensagem'])) {
?>
    <div class="mensagem">
        <?= $_SESSION['mensagem'] ?>
    </div>
    <script lang="javascript">
        setTimeout(() => {
            document.querySelector(".mensagem").style.display = "none";
        }, 4000);
    </script>
<?php
    unset($_SESSION['mensagem']);
}
?>
<header class="header">
    <figure>
        <img src="/web-backend-a/icatalogo-parte1/imgs/logo.png" alt="">
    </figure>
    <form method="POST" action="/web-backend-a/icatalogo-parte1/produtos/index.php">
        <input type="search" placeholder="Pesquisar" name="pesquisa"/>
        <button>
            <img src="/web-backend-a/icatalogo-parte1/imgs/lupa.svg">
        </button>
    </form>
    <nav>
        <ul>
            <a id="menu_admin">Administrador</a>
        </ul>
    </nav>
    <div class="container-login" id="container-login">
        <?php
        if (isset($_SESSION['msg_erro_lgn'])) {
            $mensagem_erro = $_SESSION['msg_erro_lgn'];
        ?>
            <ul>
                <li><?= $mensagem_erro ?></li>
            </ul>
        <?php
        }
        unset($_SESSION['msg_erro_lgn']);
        ?>


        <h1>Fazer login</h1>

        <form method="POST" action="../componentes/header/acoes_usuario.php">
            <input type="hidden" name="acao" value="login">
            <input type="text" placeholder="usuario" name="usuario" />
            <input type="password" placeholder="senha" name="senha" />
            <button>Entrar</button>

            <!-- teste do desafio -->
            <?php
            if (isset($_SESSION['id']) && isset($_SESSION['nome'])) {
            ?>
                <button>logout</button>
                <!-- teste -->
                <input type="hidden" name="acao" value="logout" />
            <?php
                // session_destroy();
            }
            ?>
            <button type="link" id="btn_return_home">
                <a href="/web-backend-a/icatalogo-parte1/produtos/index.php" id="link_return_home">
                    Voltar para Home
                </a>
            </button>
        </form>
    </div>
</header>
<script lang="javascript">
    //selecionamos o botão administrar e adicionamos o evento de click para ele
    document.querySelector("#menu_admin").addEventListener("click", toggleLogin);
    //função do evento do click
    function toggleLogin() {
        let containerLogin = document.querySelector("#container-login");
        let formContainer = document.querySelector("#container-login > form");
        let h1Container = document.querySelector("#container-login > h1");
        //se o container estiver oculto, motramos
        if (containerLogin.style.opacity == 0) {
            formContainer.style.display = "flex";
            h1Container.style.display = "block";
            containerLogin.style.opacity = 1;
            containerLogin.style.height = "300px";
        } else {
            //se não, ocultamos
            formContainer.style.display = "none";
            h1Container.style.display = "none";
            containerLogin.style.opacity = 0;
            containerLogin.style.height = "0px";
        }
    }
</script>