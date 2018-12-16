<?php
// подключаем файлы
session_start();

if (array_key_exists('user', $_SESSION)) {
    unset($_SESSION['user']);
    header("Location: /index.php");
    exit();
}
