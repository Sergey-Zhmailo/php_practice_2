<?php
// DB CONNECT
define('HOST', '127.0.0.1');
define('USER', 'root');
define('PASSWORD', '');
define('DATABASE', 'lesson_12');

$connect = new mysqli(HOST, USER, PASSWORD, DATABASE);

// Check connection
if ($connect->connect_error) {
    die("Ошибка подключения базы данных: " . $connect->connect_error);
}
