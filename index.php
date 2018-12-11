<?php
// подключаем файлы
require_once('functions.php');
session_start();

// заголовок
$page_name = 'Дела в поряке';

if (!isset($_SESSION['user']['id'])) {
    header("Location: /guest.php");
    exit();

}
else {
    $userId = $_SESSION['user']['id'];
}

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

$projects = getProjects($con, $userId);

$projectId = null;

//проверка типа переменной для проектов
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

$button_footer = include_template('button-footer.php');
$content_task = include_template('content-task.php', [
    'projects' => $projects,
    'tasksList' => getTasksForAuthorId($con, $userId)
]);
$sidebar = include_template('sidebar.php', [
    'content' => $content,
    'content_user' => include_template('user.php'),
    'content_task' => $content_task
]);
// формируем главную страницу

$layout_content = include_template('layout.php', [
    'sidebar' => $sidebar,
    'page_name' => $page_name,
    'button_footer'=> $button_footer,

]);
print($layout_content);
