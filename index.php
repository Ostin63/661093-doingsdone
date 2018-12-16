<?php
// подключаем файлы
require_once('connect.php');
require_once('functions.php');
session_start();

// заголовок
$page_name = 'Дела в поряке';

if (!isset($_SESSION['user']['id'])) {
    header("Location: /guest.php");
    exit();

} else {
    $userId = $_SESSION['user']['id'];
}

if (isset($_GET['task_id']) && isset($_GET['check'])) {
    changeTaskCompletion($con, $_GET['task_id'], $_GET['check'], $userId);
    if (!changeTaskCompletion($con, $_GET['task_id'], $_GET['check'], $userId)) {
        header("HTTP/1.0 404 Not Found");
        exit();
    }
}

$show_complete_tasks = isset($_GET['show_completed']) ? $_GET['show_completed'] : false;

$projects = getProjects($con, $userId);

$projectId = null;
//проверка типа переменной для проектов
if (isset($_GET['project_id'])) {
    $projectId = (int)$_GET['project_id'];
    if (!idExists($projectId, $projects)) {
        header("HTTP/1.0 404 Not Found");
        exit();
    }
}
$search = trim($_GET['search'] ?? null);

$filter = isset($_GET['filter']) ? $_GET['filter'] : null;
$currentProjectId = isset($_GET['project_id']) ? $_GET['project_id'] : null;

// подключаем контент
$content = include_template('index.php', [
    'tasksList' => getTasksForAuthorIdAndProjectedFilter($con, (int)$userId, (int)$projectId, $filter, $search),
    'show_complete_tasks' => $show_complete_tasks,
    'filter' => $filter,
    'search' => $search
]);

$button_footer = include_template('button-footer.php');
$content_task = include_template('content-task.php', [
    'projects' => $projects,
    'tasksList' => getTasksForAuthorId($con, (int)$userId),
    'currentProjectId' => $currentProjectId
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
    'button_footer' => $button_footer,

]);
print($layout_content);
