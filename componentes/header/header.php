<?php
    session_start();
?>

<link rel="stylesheet" href="/web-backend/ICatalogo/componentes/header/header.css">

<header class="header">
    <figure>
        <img src="/web-backend/ICatalogo/imgs/logo.png"/>
    </figure>
    <input type="search" placeholder="Pesquisar" />
    <?php
        if (isset($_SESSION["usuarioId"])) {
    ?>
    <nav>
        <ul>
            <a id="menu-admin">Administrar</a>
        </ul>
    </nav>
    <div class="container-login" id="container-login">
        <h1>Fazer Login</h1>
        <form method="POST" action="/web-backend/ICatalogo/componentes/header/acoesLogin.php">
            <input type="hidden" name="login" value="login"/>
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
        <form id="form-logout" style="display: none;" method="POST" action="/web-backend/ICatalogo/componentes/header/acoesLogin.php">
        <input type="hidden" name="acao" value="logout"/>
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
        } 
        else {
            h1Form.style.display = "none";
            form.style.display = "none";
            containerLogin.style.opacity = 0;
            containerLogin.style.height = "0px";
        }
    }

</script>