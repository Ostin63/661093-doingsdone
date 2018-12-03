<?php
$userId = 1;
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
$projects = getProjects($con, $userId);

$projectId = null;

if (isset($_GET['project_id'])) {
    $projectId = (int) $_GET['project_id'];
    if (!idExists($projectId, $projects)) {
        header("HTTP/1.0 404 Not Found");
        exit();
    }
}

// подключаем контент
$content = include_template('index.php', [
    'tasksList' =>  getTasksForAuthorIdAndProjected($con, $userId, $projectId),
    'show_complete_tasks' => $show_complete_tasks
]);

// заголовок
$page_name = 'Дела в поряке';

// формируем главную страницу

$layout_content = include_template('layout.php', [
    'content' => $content,
    'projects' => $projects,
    'tasksList' => getTasksForAuthorId($con, $userId),
    'page_name' => $page_name
]);
print($layout_content);
