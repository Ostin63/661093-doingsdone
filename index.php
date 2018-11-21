<?php
// подключаем файлы
require_once('functions.php');
require_once('data.php');

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

// подключаем контент
$content = include_template('index.php', [
    'tasks_list' => $tasks_list,
    'show_complete_tasks' => $show_complete_tasks
]);
// заголовок
$page_name = 'Дела в поряке';
// формируем гланую страницу
$layout_content = include_template('layout.php', [
    'content' => $content,
    'categories' => $categories,
    'tasks_list' => $tasks_list,
    'page_name' => $page_name
]);
print($layout_content);