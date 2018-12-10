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
    if (!filter_var($form['email'], FILTER_VALIDATE_EMAIL)){
        $errors['email'] = 'Е-amil указан не верно';
    }
    if (empty($errors)) {
        $res = getUserDataByEmail($con, $form['email']);
        if (mysqli_num_rows($res) > 0) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        }

        else {
            $res = addUser($con, $form['email'], $form['name'],  $form['password']);
        }
        if ($res && empty($errors)) {
            header("Location: /enter.php");
            exit();
        }
    }
    $tpl_data['errors'] = $errors;
    $tpl_data['form'] = $form;
}

// подключаем контент
$button_footer = null;
$sidebar = include_template('sidebar.php', [
    'content' => include_template('reg.php', $tpl_data),
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
