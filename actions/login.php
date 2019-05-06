<?php
session_start();
require_once '../db/db.php';

// EMAIL VALIDATION
$_SESSION['user_email'] = trim($_POST['user_email']);
$arr_user_email = explode('@', $_SESSION['user_email']);
if (empty($_SESSION['user_email'])) {
    $_SESSION['errors']['error_user_email'] = 'Поле Email не заполнено!';
    unset($_SESSION['valid_user_email']);
} elseif (count(explode(' ', $_SESSION['user_email'])) > 1) {
    $_SESSION['errors']['error_user_email'] = 'Email не должен содержать пробелов!';
    unset($_SESSION['valid_user_email']);
    $arr_user_email = [];
} elseif (count($arr_user_email) == 1) {
    $_SESSION['errors']['error_user_email'] = 'Email должен содержать @!';
    unset($_SESSION['valid_user_email']);
    $arr_user_email = [];
} elseif (count($arr_user_email) > 2) {
    $_SESSION['errors']['error_user_email'] = 'Email должен содержать один @!';
    unset($_SESSION['valid_user_email']);
    $arr_user_email = [];
} else {
    $_SESSION['valid_user_email'] = $_SESSION['user_email'];
    unset($_SESSION['errors']['error_user_email']);
}

// PASSWORD VALIDATION
$_SESSION['user_password'] = trim($_POST['user_password']);
$arr_user_password = explode(' ', $_SESSION['user_password']);
if (empty($_SESSION['user_password'])) {
    $_SESSION['errors']['error_user_password'] = 'Поле Пароль не заполнено!';
    unset($_SESSION['valid_user_password']);
} elseif (count($arr_user_password) > 1) {
    $_SESSION['errors']['error_user_password'] = 'Пароль не должен содержать пробелы!';
    unset($_SESSION['valid_user_password']);
    $arr_user_password = [];
} elseif (mb_strlen($_SESSION['user_password'], 'utf-8') < 6) {
    $_SESSION['errors']['error_user_password'] = 'Пароль должен содержать минимум 6 символов!';
    unset($_SESSION['valid_user_password']);
} elseif (mb_strlen($_SESSION['user_password'], 'utf-8') > 15) {
    $_SESSION['errors']['error_user_password'] = 'Имя должно содержать не больше 15 символов!';
    unset($_SESSION['valid_user_password']);
} else {
    $_SESSION['valid_user_password'] = $_SESSION['user_password'];
    unset($_SESSION['errors']['error_user_password']);
}

// DB QUERY EMAIL
$sql_login = "SELECT user_id, user_name, user_email, user_password FROM users WHERE user_email = ? ";
$stmt = $connect -> prepare($sql_login);
$stmt -> bind_param('s', $_SESSION['valid_user_email']);
$stmt -> execute();
$result_login = $stmt->get_result();
while ($data = $result_login->fetch_assoc()) {
    $users_result = $data;
}
$result_login -> free();
$stmt->close();
$connect->close();

// FINAL CHECK

if ($users_result && password_verify($_SESSION['valid_user_password'], $users_result['user_password'])) {
    $_SESSION['is_auth'] = $users_result['user_id'];
    $_SESSION['is_auth_name'] = $users_result['user_name'];
    unset($_SESSION['errors']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_password']);
    unset($_SESSION['valid_user_email']);
    unset($_SESSION['valid_user_password']);
    header('Location: /', true, 301);
    exit();
} else {
    $_SESSION['errors']['error_user_email'] = 'Email или пароль не найдены в базе!';
    unset($_SESSION['valid_user_email']);
    unset($_SESSION['valid_user_password']);
    header('Location: /login_page.php', true, 301);
    exit();
}

