<?php
$user = 1;
// подключаем файлы
require_once('functions.php');
require_once('mysql_helper.php');

//соединение с сервером
$con = mysqli_connect('php-project', 'root', '', 'doingsdone');
mysqli_set_charset($con, "utf8");

if ($con == false) {
    print( mysqli_connect_error());
}

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);
$projects = getProjects($con, $user);

if (isset($_GET['project_id'])) {
    $project = $_GET['project_id'];
}

// подключаем контент
$content = include_template('index.php', [
    'tasksList' => isset($project) ? getTasksForAuthorIdAndProjected($con, $user, $project) : getTasksForAuthorId($con, $user),
    'show_complete_tasks' => $show_complete_tasks
]);

// заголовок
$page_name = 'Дела в поряке';

// формируем главную страницу
$layout_content = include_template('layout.php', [
    'content' => $content,
    'projects' => $projects,
    'tasksList' => getTasksForAuthorId($con, $user),
    'page_name' => $page_name
]);
print($layout_content);
