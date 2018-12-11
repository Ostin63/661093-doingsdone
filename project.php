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

// подключаем контент
$projects = getProjects($con, $userId);
$button_footer = include_template('button-footer.php');
$content_task = include_template('content-task.php', [
    'projects' => $projects,
    'tasksList' => getTasksForAuthorId($con, $userId)
]);

//валидация формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $projects = $_POST['project'];

    $required = ['name'];
    $errors = [];
    foreach ($required as $key) {
        if (empty($projects[$key])) {
            $errors[$key] = 'Это поле обязательно';
        }
    }
    if (count($errors) > 0) {
        $content = include_template('project.php', ['project' => $projects, 'errors' => $errors]);
    }
    else {
        addProjectForm($con, $projects['name'], $_SESSION['user']['id']);
        header("Location: /index.php");
        exit();
    }
} else {
    // подключаем контент
    $content = include_template('project.php', [
        'projects' => $projects
    ]);
}

// формируем главную страницу
$content_user = include_template('user.php');
$sidebar = include_template('sidebar.php', [
    'content' => $content,
    'content_user' => $content_user,
    'content_task' => $content_task
]);
$layout_content = include_template('layout.php', [
    'sidebar' => $sidebar,
    'page_name' => $page_name,
    'button_footer'=> $button_footer
]);
print($layout_content);
