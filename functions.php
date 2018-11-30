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

//Функция вызова задач для одного автора
function getCategories($con, $user) {
    $sql = "SELECT *  FROM projects WHERE author_id = $user" ;
    $result = mysqli_query($con, $sql);
    return $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

//Функция вызова имен категорий для одного автора
function getTasksForAuthorId ($con, $user) {
    $sql = "SELECT DISTINCT tasks.*, projects.name as project_name FROM tasks INNER JOIN projects ON tasks.project_id = projects.id WHERE projects.author_id = $user";
    $result = mysqli_query($con, $sql);
    return $tasksList = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

//Функция подсчета задач по категориям
function countTasks($tasksList, $taskInfo) {
    $tasksAmount = 0;
    foreach ($tasksList as $task) {
        if ($task['project_id'] === $taskInfo) {
            $tasksAmount ++;
        }
    }
    return $tasksAmount;
}
//функция проверки остатка времени до выполнения задачи
function isTaskImportant($taskDate, $importantHours) {
    if (empty($taskDate)) return  false;
    $seconds_in_hour = 3600;
    $ts = time();
    $end_ts= strtotime($taskDate);
    $ts_diff = $end_ts - $ts;
    return floor($ts_diff / $seconds_in_hour) <= $importantHours;
}
