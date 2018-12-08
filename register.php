<?php
// подключаем файлы
require_once('functions.php');

// заголовок
$page_name = 'Дела в поряке';

// подключаем контент
$content_task = include_template('content-info.php');
$content = include_template('register.php');
$content_user = include_template('header-button-autorization.php');
$button_footer = null;
// формируем главную страницу
$layout_content = include_template('layout.php', [
    'content_user' => $content_user,
    'content' => $content,
    'page_name' => $page_name,
    'content_task' => $content_task,
    'button_footer'=> $button_footer
]);
print($layout_content);
