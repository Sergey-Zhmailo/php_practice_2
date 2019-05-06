<?php
session_start();
require_once 'db/db.php';
//$_SESSION['success_registration'] = '1';
//unset($_SESSION['errors']);
?>
<!doctype html>
<html lang="ru-RU">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP/Lesson12/</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="css/materialize.css">
    <link rel="stylesheet" href="/css/material-icons.css">
</head>
<body class="grey lighten-2">

<!--    HEADER-->
<nav class="light-blue darken-4">
    <div class="nav-wrapper">
        <div class="container">
            <a class="brand-logo">Занятие 12<?php echo $_SERVER['REQUEST_URI'] ; ?></a>
            <ul id="nav-mobile" class="right">
                <li><a href="/">Главная</a></li>
                <li <?php echo $_SESSION['is_auth'] ? 'id="account_link"' : ''; ?>><a class="account"><i class="material-icons">account_circle</i><span><?php echo $_SESSION['is_auth'] ? $_SESSION['is_auth_name'] : 'Вход не выполнен'; ?></span></a>
                    <ul id='dropdown_account_link' class='dropdown-content'>
                        <li><a class="light-blue-text text-darken-4" href="my-account.php"><i class="material-icons">account_box</i>Мой аккаунт</a></li>
                        <li><a class="light-blue-text text-darken-4" href="posts.php"><i class="material-icons">edit</i>Мои записи</a></li>
                        <li><a href="login_page.php?logout=1" class="light-blue-text text-darken-4"><i class="material-icons">close</i>Выйти из аккаунта</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!--    /HEADER-->
<?php
