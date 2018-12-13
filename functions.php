<?php
require_once('connect.php');
require_once('mysql_helper.php');

//Функция вызова проектов для одного автора
function getProjects($con, $userId) {
    $sql = "SELECT * FROM projects WHERE author_id = ?";
    $stmt = db_get_prepare_stmt($con, $sql, [$userId]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $projects = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $projects;
}

//Функция вызова имен категорий для одного автора
function getTasksForAuthorId($con, $userId) {
    $sql = "
      SELECT DISTINCT tasks.*,
      projects.name AS project_name
      FROM tasks
      INNER JOIN projects ON tasks.project_id = projects.id
      WHERE projects.author_id = ?";
    $stmt = db_get_prepare_stmt($con, $sql, [$userId]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $tasksList = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $tasksList;
}

//функция вызова всех задач
function getTasksForAuthorIdAllProjected($con, int $userId) {
    $sql = "
            SELECT DISTINCT tasks.*, projects.name AS project_name
            FROM tasks
            INNER JOIN projects ON tasks.project_id = projects.id
            WHERE projects.author_id = ?";
    $stmt = db_get_prepare_stmt($con, $sql, [$userId]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $tasksList = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $tasksList;
}

//функция вызова задач на сегодня
function getTasksForAuthorIdAndProjectedAgenda($con, int $userId) {
    $sql = "
            SELECT DISTINCT tasks. * , projects.name AS project_name
            FROM tasks
            INNER JOIN projects ON tasks.project_id = projects.id
            WHERE projects.author_id = ?
              AND DATE(tasks.date_completion) = CURDATE()";
    $stmt = db_get_prepare_stmt($con, $sql, [$userId]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $tasksList = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $tasksList;
}

//функция вызова задач на завтра
function getTasksForAuthorIdAndProjectedTomorrow ($con, int $userId) {
    $sql = "
            SELECT DISTINCT tasks. * , projects.name AS project_name
            FROM tasks
            INNER JOIN projects ON tasks.project_id = projects.id
            WHERE projects.author_id = ?
              AND DATE(tasks.date_completion) = DATE_ADD(CURDATE(), INTERVAL 1 DAY)";
    $stmt = db_get_prepare_stmt($con, $sql, [$userId]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $tasksList = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $tasksList;
}

//функция вызова просроченных задач
function getTasksForAuthorIdAndProjectedExpired($con, int $userId) {
    $sql = "
            SELECT DISTINCT tasks. * , projects.name AS project_name
            FROM tasks
            INNER JOIN projects ON tasks.project_id = projects.id
            WHERE projects.author_id = ?
              AND tasks.date_completion < NOW()" ;
    $stmt = db_get_prepare_stmt($con, $sql, [$userId]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $tasksList = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $tasksList;
}
//Функция вызова задач для одного проекта
function getTasksForAuthorIdAndProjected($con, int $userId, int $projectId) {
    $sql = "
            SELECT DISTINCT tasks.*, projects.name AS project_name
            FROM tasks
            INNER JOIN projects ON tasks.project_id = projects.id
            WHERE projects.author_id = ? AND tasks.project_id = ?";
        $stmt = db_get_prepare_stmt($con, $sql, [$userId, $projectId]);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $tasksList = mysqli_fetch_all($res, MYSQLI_ASSOC);
        return $tasksList;
}

//Функция вызова задач по фильтрации
function getTasksForAuthorIdAndProjectedFilter($con, int $userId, int $projectId=null, $filter) {
    if(empty($projectId)) {
        if ($filter ==='agenda') {
            $tasksList = getTasksForAuthorIdAndProjectedAgenda($con, (int) $userId);
        }
        else if ($filter ==='tomorrow') {
            $tasksList = getTasksForAuthorIdAndProjectedTomorrow ($con, (int) $userId);
        }
        else if ($filter ==='expired') {
            $tasksList = getTasksForAuthorIdAndProjectedExpired($con, (int) $userId);
        }
        else {
            $tasksList = getTasksForAuthorIdAllProjected($con, (int) $userId);
        }
    }
    else {
        $tasksList = getTasksForAuthorIdAndProjected($con, (int) $userId, (int) $projectId);
    }
    return $tasksList;
}
//Функция подсчета задач по категориям
function countTasks($tasksList, $projectId) {
    $tasksAmount = 0;
    foreach ($tasksList as $task) {
        if ($task['project_id'] === $projectId) {
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

function idExists($id, $entityList) {
    foreach($entityList as $entityInfo) {
        if ($id == $entityInfo['id']) {
            return true;
        }
    }
    return false;
}

//добавление задач в БД
function addTaskform($con, $name, $dateCompletion, $file, int $projectId) {
    $sql = "
    INSERT INTO tasks (name, date_creation, date_completion, file, project_id) VALUES
    (?, NOW(), ?, ?, ?)";
    $stmt = db_get_prepare_stmt($con, $sql,  [$name, $dateCompletion, $file, $projectId]);
    return mysqli_stmt_execute($stmt);
}

//добавление проектов в БД
function addProjectForm($con, $name, int $authorId) {
    $sql = "INSERT INTO projects ( name, author_id) VALUES (?, ?)";
    $stmt = db_get_prepare_stmt($con, $sql,  [$name, $authorId]);
    return mysqli_stmt_execute($stmt);
}

//проверки формата даты
function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

//добавление пользователя
function addUser($con, $email, $name,  $password) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = 'INSERT INTO users (date_creation, email, name, password, token) VALUES (NOW(), ?, ?, ?, "")';
    $stmt = db_get_prepare_stmt($con, $sql, [$email, $name, $password]);
    return mysqli_stmt_execute($stmt);
}

//проверка пользователя
function getUserDataByEmail($con, $email) {
    $email = mysqli_real_escape_string($con, $email);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    return mysqli_query($con, $sql);
}
//изменение статуса задачи
function changeTaskCompletion($con, int $taskId, int $check) {
    $sql = "UPDATE tasks SET done = ? WHERE id = ?";
    $stmt = db_get_prepare_stmt($con, $sql, [$check, $taskId]);
    return mysqli_stmt_execute($stmt);
}
