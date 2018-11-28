<?php
// подключаем файлы
require_once('functions.php');
//require_once('data.php');
$user = 1;

$con = mysqli_connect('php-project', 'root', '', 'doingsdone');
mysqli_set_charset($con, "utf8");

$sql = "SELECT *  FROM projects WHERE author_id = $user";
$result = mysqli_query($con, $sql);

$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql = "SELECT *  FROM tasks WHERE project_id IN (SELECT id FROM projects WHERE author_id = $user)";
$result = mysqli_query($con, $sql);

$tasks_list = mysqli_fetch_all($result, MYSQLI_ASSOC);

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