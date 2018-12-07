<?php
$userId = 1;
// подключаем файлы
require_once('functions.php');

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

$projects = getProjects($con, $userId);

//валидация формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task = $_POST['task'];

    $required = ['name', 'project'];
    $errors = [];
    foreach ($required as $key) {
        if (empty($task[$key])) {
            $errors[$key] = 'Это поле обязательно';
        }
    }
    $projectExists = false;
    foreach ($projects as $project) {
        if($project['id'] == $task['project']) {
            $projectExists = true;
            break;
        }
    }
    if(!$projectExists) {
        $errors['project'] = 'Неверный проект';
    }
    if ($task['date'] == '') {
        $task['date'] = null;
    }
    else if (!validateDate($task['date'])) {
        $errors['date'] = 'Не верный формат';
    }
    $fileLimit = 128000;
    if (isset($_FILES['task']['size']['file']) && $_FILES['task']['size']['file'] > 0) {
        $file_size = $_FILES['task']['size']['file'];
        if ($file_size > $fileLimit) {
            $errors['file'] = 'Файл должен быть не больше '.$fileLimit;
        } else {
            $filename = uniqid() . '-' . $_FILES['task']['name']['file'];
            $task['file'] = $filename;
            move_uploaded_file($_FILES['task']['tmp_name']['file'], 'uploads/' . $filename);
        }
    }
    else {
        $task['file'] = null;
    }
    if (count($errors) > 0) {
        $content = include_template('add.php', ['projects' => $projects, 'errors' => $errors]);
    }
    else {
        addTaskform($con, $task['name'], $task['date'], $task['file'], $task['project']);
        header("Location: /index.php");
        exit();
    }
} else {
    // подключаем контент
    $content = include_template('add.php', [
        'projects' => $projects
    ]);
}
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