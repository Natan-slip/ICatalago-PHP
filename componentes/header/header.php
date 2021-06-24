<link href="/componentes/header/header.css" rel="stylesheet" />

<?php
if (isset($_SESSION["mensagem"])) {
?>
    <div class="mensagens">
        <?= $_SESSION["mensagem"]; ?>
    </div>
    <script lang="javascript">
    
        setTimeout(() => {
            document.querySelectpr(".mensagem").style.display = "none";
        }, 4000);

    </script>
<?php
    unset($_SESSION["mensagem"]);
}
?>
</div>
<header class="header">
    <figure>
        <a href="/produtos/">
            <img src="/imgs/logo.png" />
        </a>
    </figure>
    <form method="GET" action="/produtos/index.php">
        <input type="text" placeholder="Pesquisar" name="p" id="pesquisar" value="<?= isset($_GET["p"]) ? $_GET["p"] : "" ?>"/>
        <button <?= isset($_GET["p"]) ? "onclick='limparFiltro()'" : "" ?>>
            <?php
            if(isset($_GET["p"])){
            
            
            ?>
            <img style="width: 15px;" src="/web-beckkend/icatalogo/imgs/cancel.svg" />
            <?php
            }else {
            
            ?>
            <img src="/imgs/lupa.svg" />
            <?php
            }
            ?>
        </button>
    </form>
    <?php
    if (!isset($_SESSION["usuarioId"])) {
    ?>
        <nav>
            <ul>
                <a id="menu-admin">Administrar</a>
            </ul>
        </nav>
        <div id="container-login" class="container-login">
            <h1>Fazer Login</h1>
            <form method="POST" action="/componentes/header/acoesLogin.php">
                <input type="hidden" name="acao" value="login" />
                <input type="text" name="usuario" placeholder="Usuário" />
                <input type="password" name="senha" placeholder="Senha" />
                <button>Entrar</button>
            </form>
        </div>
    <?php
    } else {
    ?>
        <nav>
            <ul>
                <a id="menu-admin" onclick="logout()">Sair</a>
            </ul>
        </nav>
        <form id="form-logout" style="display:none" method="POST" action="/componentes/header/acoesLogin.php">
            <input type="hidden" name="acao" value="logout" />
        </form>
    <?php
    }
    ?>
</header>
<script lang="javascript">
    document.querySelector("#menu-admin").addEventListener("click", toggleLogin);

    function logout() {
        document.querySelector("#form-logout").submit();
    }

    function toggleLogin() {
        let containerLogin = document.querySelector("#container-login");
        let h1Form = document.querySelector("#container-login > h1");
        let form = document.querySelector("#container-login > form");
        //se estiver oculto, mostra 
        if (containerLogin.style.opacity == 0) {
            h1Form.style.display = "block";
            form.style.display = "flex";
            containerLogin.style.opacity = 1;
            containerLogin.style.height = "200px";
            //se não, oculta
        } else {
            h1Form.style.display = "none";
            form.style.display = "none";
            containerLogin.style.opacity = 0;
            containerLogin.style.height = "0px";
        }
    }
</script>