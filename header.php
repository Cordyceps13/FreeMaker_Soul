<?php
include 'configs.php';
$current_page = basename($_SERVER['PHP_SELF']);
@$adm = $_SESSION['adm'];
?>
<!DOCTYPE html>
<html lang="pt_PT">

<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="imgs/logos/logoo.png">
    <title> <?= @$title ?> - FreeMaker_Soul</title>
    <link rel="stylesheet" href="includes/styles.css">
    <script src="includes/js/jquery-3.7.1.min.js"></script>
    <script  src="includes/js/main.js"></script>
</head>

<body>
<?php
@$msg = $_GET['msg'];
@$error_msg = $_SESSION['error_msg'];
@$info_msg = $_SESSION['info_msg'];
?>
<div class="backdrop" id="msg_backdrop">
    <div class="msg_container wrapper">
        <img id="close_msg" class="close_msg" src="imgs/icons/close.png" alt="">
        <div class="msg">
            <?php
            switch ($msg) {
                case 'ja_ha_registo':
                    echo ' Já existe uma conta com este email ou nome de utilizador 
                           <a href="#" id="try_signup">[Tente novamente]</a>';
                    break;

                case 'registo_error':
                    echo 'Não foi possível realizar o seu registo<br><br>
                          <a href="#" id="try_signup">[Tente novamente]</a>';
                    break;

                case 'registo_success':
                    echo 'Registo efetuado com sucesso!<br><br>
                          Redirecionando para a página de login';
                    break;

                case 'nao_ha_registo':
                    echo 'Ainda não efetuou registo no nosso site<br><br>
                          Registe-se <a href="#" id="try_signup">[aqui]</a>';
                    break;

                case 'login_error':
                    echo 'Email, nome de utilizador ou palavra passe incorretos.<br><br>
                          <a href="#" id="try_login">[Tente novamente]</a>';
                    break;

                case 'login_success':
                    echo 'Login efetuado com sucesso!';
                    break;

                case 'logout':
                    echo 'Sessão terminada';
                    break;

                case 'error':
                    echo $error_msg;
                    break;
                case 'success':
                    echo $info_msg;
                    break;
            }
            ?>
        </div>
    </div>
</div>
<div class="backdrop" id="login_backdrop">
    <form class="form wrapper" id="form_login" action="actions.php?act=login" method="POST" enctype="multipart/form-data">
        <div class="login_container">
            <div class="log_btn_container">
                <img id="close_login" class="close_msg" src="imgs/icons/close.png" alt="">
            </div>
        </div>
        <div class="titulo">Login</div>
        <div class="input-box" id="login_name_input">
            <input type="text" id="name_login" name="nickname" placeholder="Email ou nome de utilizador">
            <img src="imgs/icons/login-avatar.png" alt="nome de utilizador">
        </div>
        <div class="login_error_msg">Introduza o seu email ou nome de utilizador!</div>
        <div class="input-box" id="login_pwd_input">
            <input type="password" id="pwd_login" name="password" placeholder="Password">
            <img class="eye" src="imgs/icons/closed-eye.png" alt="visualizar password" title="visualizar password">
        </div>
        <div class="login_error_msg">Tem que introduzir a sua password!</div>
        <div class="remember-forgot">
            <label for="remember">
                <input type="checkbox" id="remember" name="remember" valign="center">
                Lembrar-me
            </label>
            <a href="#">Esqueci a Password</a>
        </div>
        <input class="btn" id="login_btn" type="submit" value="Login">
        <div class="register-link">
            Ainda não efetuou registo?
            <a id="registar" href="#">Registar</a>
        </div>
    </form>
</div>
<div class="backdrop" id="signup_backdrop">
    <form class="form wrapper" id="form_signup" action="actions.php?act=register" method="POST" enctype="multipart/form-data">
        <div class="container">
            <div class="log_btn_container">
                <img id="back" class="close_msg" src="imgs/icons/back.png" alt="">
            </div>
            <div class="log_btn_container">
                <img id="close_signup" class="close_msg" src="imgs/icons/close.png" alt="">
            </div>
        </div>
        <div class="titulo">Registar</div>
        <div class="input-box">
            <input type="text" id="name_signup" name="nickname" placeholder="Nome de utilizador">
            <img src="imgs/icons/login-avatar.png" alt="nome de utilizador">
        </div>
        <div class="signup_error_msg">É necessário introduzir um nome de utilizador!</div>
        <div class="input-box">
            <input type="email" id="email_signup" name="email" placeholder="Email">
            <img src="imgs/icons/at.png" alt="nome de utilizador">
        </div>
        <div class="signup_error_msg">O campo Email tem que ser preenchido!</div>
        <div class="input-box">
            <input type="password" id="pwd_signup" name="password" placeholder="Password" minlength="8">
            <img class="eye" src="imgs/icons/closed-eye.png" alt="visualizar password">
        </div>
        <div class="signup_error_msg">Tem que introduzir uma password com um mínimo de 8 caracteres!</div>
        <div class="input-box">
            <input type="password" id="re_pwd_signup" name="re_password" placeholder="Repetir password">
            <img class="re_eye" src="imgs/icons/closed-eye.png" alt="visualizar password">
        </div>
        <div class="signup_error_msg">As passwords não coincidem!</div>
        <input class="btn" id="submit_register" name="submit" type="submit" value="Registar">
    </form>
</div>
<div class="header">
    <div class="wrapper">
        <a class="logo" href="index.php">
            <img src="imgs/logos/logo.png" alt="Logotipo do proprietário" title="Página principal">
        </a>
        <div class="menu">
            <a class="link" href="index.php" title="Página principal">Home</a>
            <a class="link" href="products.php" title="Todos os produtos">Produtos</a>
            <li class="categorias link" tabindex="0"><a href="#">Categorias</a>
                <ul class="submenu">
                    <li><a class="link" href="products.php?categoria=Figuras">Figuras</a></li>
                    <li><a class="link" href="products.php?categoria=Decor">Decor</a></li>
                    <li><a class="link" href="products.php?categoria=Gaming">Gaming</a></li>
                    <li><a class="link" href="products.php?categoria=Misc">Misc</a></li>
                    <li><a class="link" href="products.php?categoria=Porta-Chaves">Porta-Chaves</a></li>
                    <li><a class="link" href="products.php?categoria=Utensílios">Utensílios</a></li>
                </ul>
            </li>
        </div>
        <div class="menu2">
            <form class="search-bar">
                <input type="text" placeholder="Pesquisar">
                <a href="products.php?act=search">
                    <img src="imgs/icons/search.png" alt="lupa de pesquisa" title="Pesquisar">
                </a>
            </form>
            <?php
            if ($_SESSION) {
            ?>
                <li class="profile_container">
                    <?php
                    if ($adm) {
                    ?>
                        <img class="avatar" src="imgs/icons/crown.png" alt="Foto de perfil">
                        <?php
                    } else {
                        $stmt = $conn->prepare('SELECT foto FROM utilizadores WHERE nome = ?');
                        $stmt->bind_param('s', $_SESSION['nome']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $user = $result->fetch_assoc();

                        if ($user && $user['foto']) {
                        ?>
                            <img class="user_pic" src="imgs/profile_pics/' . $user['foto'] . '" alt="Foto de perfil">
                        <?php
                        } else {
                        ?>
                            <img class="avatar" src="imgs/icons/login-avatar.png" alt="Foto de perfil">
                    <?php
                        }
                    }
                    ?>
                    <ul class="profile-options">
                        <?php
                        if ($adm) {
                        ?>
                            <li>
                                <a class="profile_config" href="adm_configs.php">Configurar</a>
                            </li>
                            <li class="logout">
                                <a href="actions.php?act=logout" title="Terminar sessão">Logout</a>
                            </li>
                        <?php
                        } else {
                        ?>
                            <li>
                                <a class="profile" href="profile.php">Ver perfil</a>
                            </li>
                            <li class="logout">
                                <a href="actions.php?act=logout" title="Terminar sessão">Logout</a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </li>
            <?php
            } else {
            ?>
                <a class="login" id="login" href="#" title="Efetuar login">Login</a>
            <?php
            }
            ?>
        </div>
    </div>
</div>


<script>
    //variável global 'var' a ser acedida pelo ficheiro main.js
    var msg = "<?= $msg ?>";
</script>