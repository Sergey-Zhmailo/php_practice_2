<?php
session_start();
// LOGOUT
if ($_GET['logout']) {
    unset($_SESSION['is_auth']);
    unset($_GET['logout']);
    header('Location: /login_page.php', true, 301);
    exit();
}
if ($_SESSION['is_auth']) {
    header('Location: /', true, 301);
    exit();
}
// header
require_once 'header.php';


?>
<!--main content-->
<div class="main">
    <div class="container">
        <form action="actions/login.php" method="post" class="card grey lighten-2 m-auto" novalidate>
            <h4 class="center-align">Авторизация</h4>
            <div class="row">
                <div class="col s12">
                    <label for="user_email">Email</label>
                    <input type="email"
                           id="user_email"
                           name="user_email"
                           value="<?php echo !empty($_SESSION['valid_user_email']) ? $_SESSION['valid_user_email'] : $_SESSION['user_email']; ?>"
                        <?php echo !empty($_SESSION['errors']['error_user_email']) ? 'class="error"' : '' ?>
                    >
                    <?php echo !empty($_SESSION['errors']['error_user_email']) ? '<span class="error">' . $_SESSION['errors']['error_user_email'] . '</span>' : '' ?>
                    <label for="user_password">Пароль</label>
                    <input type="password"
                           id="user_password"
                           name="user_password"
                           value=""
                        <?php echo !empty($_SESSION['errors']['error_user_password']) ? 'class="error"' : '' ?>
                    >
                    <?php echo !empty($_SESSION['errors']['error_user_password']) ? '<span class="error">' . $_SESSION['errors']['error_user_password'] . '</span>' : '' ?>
                </div>
            </div>
            <div class="row">
                <div class="col s6">
                    <button type="submit" class="btn waves-effect waves-light light-blue darken-4">Войти</button>
                </div>
                <div class="col s6">
                    <a href="register_page.php" class="btn waves-effect waves-light light-blue darken-4 right">Регистрация</a>
                </div>
            </div>
        </form>
    </div>
</div>
<?php

// footer
require_once 'footer.php';
?>
