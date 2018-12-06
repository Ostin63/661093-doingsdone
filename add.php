<?php
$userId = 1;
// подключаем файлы
require_once('functions.php');

//соединение с сервером
$con = mysqli_connect('php-project', 'root', '', 'doingsdone');
mysqli_set_charset($con, "utf8");

if ($con == false) {
    print( mysqli_connect_error());
}

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

$projects = getProjects($con, $userId);

//валидация формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task = $_POST['task'];

    $required = ['name'];
    $errors = [];
    foreach ($required as $key) {
        if (empty($task[$key])) {
            $errors[$key] = 'Пожалуйста, исправьте ошибки в форме';
        }
    }
    if (isset($_FILES['task']['size']['file']) && $_FILES['task']['size']['file'] > 0) {
        $file_size = $_FILES['task']['size']['file'];
        if ($file_size > 128000) {
            $errors['file'] = 'Большой файл. Пожалуйста, исправьте ошибки в форме ';
        } else {
            $filename = uniqid() . '-' . $_FILES['task']['name']['file'];
            $task['file'] = $filename;
            move_uploaded_file($_FILES['task']['tmp_name']['file'], 'uploads/' . $filename);
        }
    } else {
        $task['file'] = null;
    }
    if ($task['date'] == '') {
        $task['date'] = null;
    }
    if (count($errors)) {
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