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
function filter_data($tasks_list, $filterKey) {
    foreach ($tasks_list as $key => $task) {
        $tasks_list[$key][$filterKey] = strip_tags($task[$filterKey]);
    }
    return $tasks_list;
}