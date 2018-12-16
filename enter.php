<?php
// подключаем файлы
require_once('connect.php');
require_once('functions.php');
session_start();
// заголовок
$page_name = 'Дела в поряке';


//валидация формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST['form_ent'];

    $required = ['email', 'password'];
    $errors = [];
    foreach ($required as $field) {
        if (empty($form[$field])) {
            $errors[$field] = 'Это поле обязательно';
        }
    }
    $res = getUserDataByEmail($con, $form['email']);

    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

    if (!count($errors) and $user) {
        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        }
        else {
            $errors['password'] = 'Неверный пароль';
        }
    }
    else {
        $errors['email'] = 'Такой пользователь не найден';
    }

    if (count($errors)) {
        $content = include_template('enter.php', ['form' => $form, 'errors' => $errors]);
    }
    else {
        header("Location: /index.php");
        exit();
    }

}
else {
    if (isset($_SESSION['user']));{
        $content = include_template('enter.php', []);
    }
}
// подключаем контент
$button_footer = null;
$sidebar = include_template('sidebar.php', [
    'content' => $content,
    'content_user' => include_template('header-button-reg.php'),
    'content_task' => include_template('content-info.php')
]);
// формируем главную страницу
$layout_content = include_template('layout.php', [
    'sidebar' => $sidebar,
    'page_name' => $page_name,
    'button_footer'=> $button_footer
]);
print($layout_content);
