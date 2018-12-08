<?php
// подключаем файлы
require_once('functions.php');

// заголовок
$page_name = 'Дела в поряке';

//валидация формы
$tpl_data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST['form_reg'];
    $errors = [];

    $req_fields = ['email', 'password', 'name'];

    foreach ($req_fields as $field) {
        if (empty($form[$field])) {
            $errors[$field] = "Это поле обязательно";
        }
    }

    if (empty($errors)) {
        $res = userCheck($con, $form['email']);

        if (mysqli_num_rows($res) > 0) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        }
        else {
            $res = addUser($con, $form['email'], $form['name'],  $form['password']);
        }
        if ($res && empty($errors)) {
            header("Location: /index.php");
            exit();
        }
    }
    $tpl_data['errors'] = $errors;
    $tpl_data['form'] = $form;
}

// подключаем контент
$content = include_template('register.php', $tpl_data);
$content_task = include_template('content-info.php');
$content_user = include_template('header-button-reg.php');
$button_footer = null;

// формируем главную страницу
$layout_content = include_template('layout.php', [
    'content_user' => $content_user,
    'content' => $content,
    'page_name' => $page_name,
    'content_task' => $content_task,
    'button_footer'=> $button_footer
]);
print($layout_content);
