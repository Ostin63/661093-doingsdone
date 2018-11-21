<?php
function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!file_exists($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}
//Функция подсчета задач по категориям
function countTasks($tasks_list, $val) {
    $tasksAmount = 0;
    foreach ($tasks_list as $task) {
        if ($task['category'] === $val) {
            $tasksAmount ++;
        }
    }
    return $tasksAmount;
}

// функция защиты от XSS
function filter_data($tasks_list, $keys) {
    foreach ($tasks_list as &$val) {
        foreach ($keys as $key) {
            $val[$key] = strip_tags($val[$key]);
        }
    }
    return $tasks_list;
}