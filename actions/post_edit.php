<?php
session_start();
require_once '../db/db.php';
unset($_SESSION['user_password']);
unset($_SESSION['user_password_repeat']);
unset($_SESSION['errors']['error_user_password']);
unset($_SESSION['errors']['error_user_password_repeat']);

// TITLE VALIDATION
$_SESSION['post_title'] = trim($_POST['post_title']);

if (empty($_SESSION['post_title'])) {
    $_SESSION['errors']['error_post_title'] = 'Поле Заголовок не заполнено!';
    unset($_SESSION['valid_post_title']);
} elseif (mb_strlen($_SESSION['post_title'], 'utf-8') < 4) {
    $_SESSION['errors']['error_post_title'] = 'Заголовок должен содержать минимум 4 символа!';
    unset($_SESSION['valid_post_title']);
} elseif (mb_strlen($_SESSION['post_title'], 'utf-8') > 25) {
    $_SESSION['errors']['error_post_title'] = 'Заголовок должен содержать не больше 15 символов!';
    unset($_SESSION['valid_post_title']);
} else {
    $_SESSION['valid_post_title'] = $_SESSION['post_title'];
    unset($_SESSION['errors']['error_post_title']);
    unset($_SESSION['post_title']);
}
// TEXT VALIDATION
$_SESSION['post_text'] = trim($_POST['post_text']);

if (empty($_SESSION['post_text'])) {
    $_SESSION['errors']['error_post_text'] = 'Поле Текст не заполнено!';
    unset($_SESSION['valid_post_text']);
} elseif (mb_strlen($_SESSION['post_text'], 'utf-8') < 4) {
    $_SESSION['errors']['error_post_text'] = 'Текст должен содержать минимум 4 символа!';
    unset($_SESSION['valid_post_text']);
} elseif (mb_strlen($_SESSION['post_text'], 'utf-8') > 55) {
    $_SESSION['errors']['error_post_text'] = 'Текст должен содержать не больше 55 символов!';
    unset($_SESSION['valid_post_text']);
} else {
    $_SESSION['valid_post_text'] = $_SESSION['post_text'];
    unset($_SESSION['errors']['error_post_text']);
    unset($_SESSION['post_text']);
}

// EDIT
if (!empty($_SESSION['post_edit']) &&
    empty($_SESSION['errors']) &&
    !empty($_SESSION['valid_post_title']) &&
    !empty($_SESSION['valid_post_text'])) {

    $sql = "UPDATE posts SET post_title = ?, post_text = ? WHERE post_id = '" . $_SESSION['post_edit'] ."'";
    $stmt = $connect -> prepare($sql);
    $stmt -> bind_param('ss', $_SESSION['valid_post_title'], $_SESSION['valid_post_text']);
    if ($stmt->execute()) {
        // SUCCESS

        unset($_SESSION['valid_post_title']);
        unset($_SESSION['valid_post_text']);
        unset($_SESSION['post_text']);
        unset($_SESSION['post_title']);
        unset($_SESSION['errors']);
        unset($_SESSION['post_edit']);

        $stmt->close();
        $connect->close();

    } else {
        $stmt->close();
        $connect->close();
    }

}
// POST
if (empty($_SESSION['post_edit']) &&
    empty($_SESSION['errors']) &&
    !empty($_SESSION['valid_post_title']) &&
    !empty($_SESSION['valid_post_text'])) {

    $sql = "INSERT INTO posts ( author_id, post_title, post_text ) VALUES (?,?,?)";
    $stmt = $connect -> prepare($sql);
    $stmt -> bind_param('iss', $_SESSION['user_id'], $_SESSION['valid_post_title'], $_SESSION['valid_post_text']);
    if ($stmt->execute()) {
        // SUCCESS

        unset($_SESSION['valid_post_title']);
        unset($_SESSION['valid_post_text']);
        unset($_SESSION['post_text']);
        unset($_SESSION['post_title']);
        unset($_SESSION['errors']);

        $stmt->close();
        $connect->close();

    } else {
        $stmt->close();
        $connect->close();
    }


}
//DELETE POST
if (!empty($_GET['delete'])) {
    $sql = "DELETE FROM posts WHERE post_id = '" . $_GET['delete'] ."'";
    $query = mysqli_query($connect, $sql);
    unset($_SESSION['valid_post_title']);
    unset($_SESSION['valid_post_text']);
    unset($_SESSION['post_text']);
    unset($_SESSION['post_title']);
    unset($_SESSION['errors']);
}

// REDIRECT
header('Location: /posts.php', true, 301);
exit();
