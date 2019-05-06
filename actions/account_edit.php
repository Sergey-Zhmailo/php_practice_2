<?php
session_start();
require_once '../db/db.php';


// NAME VALIDATION
if (!empty($_POST['user_name'])) {
    $_SESSION['user_name'] = trim($_POST['user_name']);
    $arr_user_name = explode(' ', $_SESSION['user_name']);

// Name exist
    $sql_check_name_exist = "SELECT user_name FROM users WHERE user_name = ?";
    $stmt = $connect -> prepare($sql_check_name_exist);
    $stmt -> bind_param('s', $_SESSION['user_name']);
    $stmt -> execute();
    $result_name = $stmt->get_result();
    $rows_name = $result_name->num_rows;
    $result_name -> free();
    $stmt->close();

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
}
if (empty($_SESSION['errors']) && !empty($_SESSION['valid_user_name'])) {
    $sql = "UPDATE users SET user_name = ? WHERE user_id = '" . $_SESSION['user_id'] . "'";
    $stmt = $connect -> prepare($sql);
    $stmt -> bind_param('s', $_SESSION['valid_user_name']);
    if ($stmt->execute()) {
        // SUCCESS
        $_SESSION['success']['success_user_name'] = 'Имя обновлено успешно!';
        $_SESSION['is_auth_name'] = $_SESSION['valid_user_name'];
        unset($_SESSION['valid_user_name']);
        unset($_SESSION['errors']['error_user_name']);
        unset($_SESSION['user_name']);

        $stmt->close();
        $connect->close();
        // REDIRECT
//        header('Location: /my-account.php', true, 301);
//        exit();
    } else {
        $_SESSION['errors']['error_user_name'] = 'Ошибка записи!';
        unset($_SESSION['valid_user_name']);
        $stmt->close();
        $connect->close();
//        header('Location: /my-account.php', true, 301);
//        exit();
    }
} else {
//    $connect->close();
//    header('Location: /my-account.php', true, 301);
//    exit();
}

// EMAIL VALIDATION
if (!empty($_POST['user_email'])) {
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
    if (empty($_SESSION['errors']) && !empty($_SESSION['valid_user_email'])) {
        $sql = "UPDATE users SET user_email = ? WHERE user_id = '" . $_SESSION['user_id'] . "'";
        $stmt = $connect -> prepare($sql);
        $stmt -> bind_param('s', $_SESSION['valid_user_email']);
        if ($stmt->execute()) {
            // SUCCESS
            $_SESSION['success']['success_user_email'] = 'Email обновлен успешно!';
            unset($_SESSION['valid_user_email']);
            unset($_SESSION['errors']['error_user_email']);
            unset($_SESSION['user_email']);

            $stmt->close();
            $connect->close();
        } else {
            $_SESSION['errors']['error_user_email'] = 'Ошибка записи!';
            unset($_SESSION['valid_user_email']);
            $stmt->close();
            $connect->close();
        }
    }
}

// PASSWORD VALIDATION
if (!empty($_POST['user_password'])) {
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
    if (empty($_SESSION['errors']) && !empty($_SESSION['valid_user_password'])) {
        $sql = "UPDATE users SET user_password = ? WHERE user_id = '" . $_SESSION['user_id'] . "'";
        $stmt = $connect -> prepare($sql);
        $stmt -> bind_param('s', $_SESSION['valid_user_password']);
        if ($stmt->execute()) {
            // SUCCESS
            $_SESSION['success']['success_user_password'] = 'Пароль обновлен успешно!';
            unset($_SESSION['valid_user_password']);
            unset($_SESSION['errors']['error_user_password']);
            unset($_SESSION['user_password']);

            $stmt->close();
            $connect->close();
        } else {
            $_SESSION['errors']['error_user_password'] = 'Ошибка записи!';
            unset($_SESSION['valid_user_password']);
            $stmt->close();
            $connect->close();
        }
    }

}

// GENDER VALIDATION
if (!empty($_POST['gender']) && ($_POST['gender'] == 1 || $_POST['gender'] == 2)) {
    $_SESSION['valid_gender'] = $_POST['gender'];
    unset($_SESSION['errors']['error_gender']);

    $sql = "UPDATE users SET user_gender = ? WHERE user_id = '" . $_SESSION['user_id'] . "'";
    $stmt = $connect -> prepare($sql);
    $stmt -> bind_param('i', $_SESSION['valid_gender']);
    if ($stmt->execute()) {
        // SUCCESS
        $_SESSION['success']['success_user_gender'] = 'Пол обновлен успешно!';
        unset($_SESSION['valid_gender']);
        unset($_SESSION['errors']['error_gender']);

        $stmt->close();
        $connect->close();
    } else {
        $_SESSION['errors']['error_gender'] = 'Ошибка записи!';
        unset($_SESSION['valid_gender']);
        $stmt->close();
        $connect->close();
    }

} else {
    $_SESSION['errors']['error_gender'] = 'Не выбран пол!';
    unset($_SESSION['valid_gender']);
}



header('Location: /my-account.php', true, 301);
exit();