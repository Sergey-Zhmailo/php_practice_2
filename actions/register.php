<?php
session_start();
require_once '../db/db.php';

// NAME VALIDATION
$_SESSION['user_name'] = trim($_POST['user_name']);
$arr_user_name = explode(' ', $_SESSION['user_name']);

// Name exist
$sql_check_name_exist = "SELECT user_name FROM users WHERE user_name = ?";
$stmt = $connect -> prepare($sql_check_name_exist);
$stmt -> bind_param('s', $_SESSION['user_name']);
$stmt -> execute();
$result_name = $stmt->get_result(); // получаем результат из подготовленного запроса
$rows_name = $result_name->num_rows; // получаем кол-во строк в полученном результате из запроса
$result_name -> free(); // очищаем результат
$stmt->close(); // закрываем подготовленный запрос

if (empty($_SESSION['user_name'])) {
    $_SESSION['errors']['error_user_name'] = 'Поле Имя не заполнено!';
    unset($_SESSION['valid_user_name']);
} elseif (count($arr_user_name) > 1) {
    $_SESSION['errors']['error_user_name'] = 'Имя должно содержать одно слово!';
    unset($_SESSION['valid_user_name']);
    $arr_user_name = [];
} elseif (mb_strlen($_SESSION['user_name'], 'utf-8') < 4) {
    $_SESSION['errors']['error_user_name'] = 'Имя должно содержать минимум 4 символа!';
    unset($_SESSION['valid_user_name']);
} elseif (mb_strlen($_SESSION['user_name'], 'utf-8') > 15) {
    $_SESSION['errors']['error_user_name'] = 'Имя должно содержать не больше 15 символов!';
    unset($_SESSION['valid_user_name']);
} elseif ($rows_name) {
    $_SESSION['errors']['error_user_name'] = 'Имя занято!';
    unset($_SESSION['valid_user_name']);
    $rows_name ='';
} else {
    $_SESSION['valid_user_name'] = $_SESSION['user_name'];
    unset($_SESSION['errors']['error_user_name']);
    unset($_SESSION['user_name']);
}

// EMAIL VALIDATION
$_SESSION['user_email'] = trim($_POST['user_email']);
$arr_user_email = explode('@', $_SESSION['user_email']);
// Email exist
$sql_check_email_exist = "SELECT user_email FROM users WHERE user_email = ?";
$stmt = $connect -> prepare($sql_check_email_exist);
$stmt -> bind_param('s', $_SESSION['user_email']);
$stmt -> execute();
$result_email = $stmt->get_result();
$rows_email = $result_email->num_rows;
$result_email -> free();
$stmt -> close();

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
} elseif ($rows_email) {
    $_SESSION['errors']['error_user_email'] = 'Такой Email уже зарегистрирован!';
    unset($_SESSION['valid_user_name']);
    $rows_email ='';
} else {
    $_SESSION['valid_user_email'] = $_SESSION['user_email'];
    unset($_SESSION['errors']['error_user_email']);
    unset($_SESSION['user_email']);
}

// PASSWORD VALIDATION
$_SESSION['user_password'] = trim($_POST['user_password']);
$_SESSION['user_password_repeat'] = trim($_POST['user_password_repeat']);
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
} elseif ($_SESSION['user_password_repeat'] != $_SESSION['user_password']) {
    $_SESSION['errors']['error_user_password_repeat'] = 'Пароль не совпадает!';
    unset($_SESSION['valid_user_password']);
} else {
    $_SESSION['valid_user_password'] = password_hash($_SESSION['user_password'], PASSWORD_DEFAULT);
    unset($_SESSION['errors']['error_user_password']);
    unset($_SESSION['errors']['error_user_password_repeat']);
    unset($_SESSION['user_password']);
    unset($_SESSION['user_password_repeat']);
}
// GENDER VALIDATION
if (!empty($_POST['gender']) && ($_POST['gender'] == 1 || $_POST['gender'] == 2)) {
    $_SESSION['valid_gender'] = $_POST['gender'];
    unset($_SESSION['errors']['error_gender']);
} else {
    $_SESSION['errors']['error_gender'] = 'Не выбран пол!';
    unset($_SESSION['valid_gender']);
}

// FINAL CHECK
if (empty($_SESSION['errors']) &&
    !empty($_SESSION['valid_user_name']) &&
    !empty($_SESSION['valid_user_email']) &&
    !empty($_SESSION['valid_user_password']) &&
    !empty($_SESSION['valid_gender'])) {
    // DB QUERY
    $sql = "INSERT INTO users ( user_name, user_email, user_password, user_gender ) VALUES (?,?,?,?)"; // объявляем переменную с запросом
    $stmt = $connect -> prepare($sql); // подготавливаем наш запрос
    $stmt -> bind_param('ssss', $_SESSION['valid_user_name'], $_SESSION['valid_user_email'], $_SESSION['valid_user_password'], $_SESSION['valid_gender']); // присваеваем первому ? в запросе параметр с типом данных s (string)
    //$stmt->execute(); // выполняем подготовленный запрос
    if ($stmt->execute()) {
        // SUCCESS
        $reg_user_id = mysqli_fetch_assoc(mysqli_query($connect, "SELECT user_id FROM users WHERE user_name = '" . $_SESSION['valid_user_name'] . "'"));
        $_SESSION['is_auth'] = $reg_user_id['user_id'];
        $_SESSION['is_auth_name'] = $_SESSION['valid_user_name'];
        unset($_SESSION['valid_gender']);
        unset($_SESSION['valid_user_email']);
        unset($_SESSION['valid_user_password']);
        unset($_SESSION['valid_user_name']);
        unset($_SESSION['errors']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_password']);
        unset($_SESSION['user_gender']);

        $stmt->close(); // закрываем подготовленный запрос
        $connect->close();
        // REDIRECT
        header('Location: /index.php', true, 301);
        exit();
    } else {
        $stmt->close();
        $connect->close();
        header('Location: /register_page.php', true, 301);
        exit();
    }


} else {
    $connect->close(); // закрываем подключение
    header('Location: /register_page.php', true, 301);
    exit();
}


