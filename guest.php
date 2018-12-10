<?php
// подключаем файлы
require_once('functions.php');
session_start();

// заголовок
$page_name = 'Дела в поряке';

// подключаем контент
$button_footer = null;
$content_user = include_template('header-button-reg.php');
$sidebar = include_template('guest.php', [
    'content_user' => $content_user
]);
// формируем главную страницу
$layout_content = include_template('layout.php', [
    'sidebar' => $sidebar,
    'page_name' => $page_name,
    'button_footer'=> $button_footer,
    'body_classname' => 'body-background'
]);
print($layout_content);