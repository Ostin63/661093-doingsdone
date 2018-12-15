<?php
require_once('connect.php');
require_once('mysql_helper.php');

//Функция вызова проектов для одного автора
/**
 * Функция-шаблонизатор
 * @param $name
 * @param $data
 * @return false|string
 */
function getProjects($con, $userId) {
    $sql = "SELECT * FROM projects WHERE author_id = ?";
    $stmt = db_get_prepare_stmt($con, $sql, [$userId]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $projects = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $projects;
}

/**
 * Функция вызова имен категорий для одного автора
 * @param $con mysqli Ресурс соединения
 * @param $sql запрос с плейсхолдерами вместо значений
 * @param $userId Данные для вставки на место плейсхолдеров
 * @return $tasksList
 */
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

/**
 * функция вызова всех задач для одного автора
 * @param $con mysqli Ресурс соединения
 * @param $sql запрос с плейсхолдерами вместо значений
 * @param $userId Данные для вставки на место плейсхолдеров
 * @return $tasksList
 */
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

/**
 * функция вызова задач на сегодня для одного автора
 * @param $con mysqli Ресурс соединения
 * @param $sql запрос с плейсхолдерами вместо значений
 * @param CURDATE() параметр даты
 * @param $userId Данные для вставки на место плейсхолдеров
 * @return $tasksList
 */
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

/**
 * функция вызова задач на завтра для одного автора
 * @param $con mysqli Ресурс соединения
 * @param $sql запрос с плейсхолдерами вместо значений
 * @param DATE_ADD(CURDATE(), INTERVAL 1 DAY) параметр даты
 * @param $userId Данные для вставки на место плейсхолдеров
 * @return $tasksList
 */
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

/**
 * функция вызова просроченных задач для одного автора
 * @param $con mysqli Ресурс соединения
 * @param $sql запрос с плейсхолдерами вместо значений
 * @param tasks.date_completion < NOW() параметр даты
 * @param $userId Данные для вставки на место плейсхолдеров
 * @return $tasksList
 */
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

/**
 * Функция вызова задач проекта для одного автора
 * @param $con mysqli Ресурс соединения
 * @param $sql запрос с плейсхолдерами вместо значений
 * @param $userId, $projectId Данные для вставки на место плейсхолдеров
 * @return $tasksList
 */
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

/**
 * Функция поле поиска для одного автора
 * @param $con mysqli Ресурс соединения
 * @param $sql запрос с плейсхолдерами вместо значений
 * @param $search, $userId Данные для вставки на место плейсхолдеров
 * @return $tasksList
 */
function searchTaskAuthor($con, $search, int $userId) {
    $sql = "SELECT tasks.*, projects.name AS project_name FROM tasks
            JOIN projects ON projects.id = tasks.project_id
		    WHERE MATCH(tasks.name) AGAINST(?) AND projects.author_id = ?";
    $stmt = db_get_prepare_stmt($con, $sql, [$search, $userId]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Функция вызова задач по фильтрации для одного автора
 * @param $con mysqli Ресурс соединения
 * @param $projectId, $search, $filter обработка параметров
 * @return $tasksList
 */
function getTasksForAuthorIdAndProjectedFilter($con, int $userId, int $projectId=null, $filter=null, $search=null) {
    if (!empty($projectId)) {
        return getTasksForAuthorIdAndProjected($con, (int) $userId, (int) $projectId);
    }
    else if (!empty($search)) {
        return searchTaskAuthor($con, $search, (int) $userId);
    }
    else {
        switch($filter) {
            case 'agenda' :
                return getTasksForAuthorIdAndProjectedAgenda($con, (int) $userId);
            case 'tomorrow' :
                return getTasksForAuthorIdAndProjectedTomorrow ($con, (int) $userId);
            case 'expired' :
                return getTasksForAuthorIdAndProjectedExpired($con, (int) $userId);
            default :
                return getTasksForAuthorIdAllProjected($con, (int) $userId);
        }
    }
}

/**
 * Функция подсчета задач по категориям для одного автора
 * @param $tasksList список задач
 * @param $projectId список проуктов
 * @return $tasksAmount
 */
function countTasks($tasksList, $projectId) {
    $tasksAmount = 0;
    foreach ($tasksList as $task) {
        if ($task['project_id'] === $projectId) {
            $tasksAmount ++;
        }
    }
    return $tasksAmount;
}

/**
 * функция проверки остатка времени до выполнения задачи
 * @param $taskDate дата выполнения задачи
 * @param $importantHours остаток времени
 * @return $importantHours
 */
function isTaskImportant($taskDate, $importantHours) {
    if (empty($taskDate)) return  false;
    $seconds_in_hour = 3600;
    $ts = time();
    $end_ts= strtotime($taskDate);
    $ts_diff = $end_ts - $ts;
    return floor($ts_diff / $seconds_in_hour) <= $importantHours;
}

/**
 * проверка существования пользователя
 * @param $id БД авторов
 * @param $entityList введенние данные
 * @return true|false
 */
function idExists($id, $entityList) {
    foreach($entityList as $entityInfo) {
        if ($id == $entityInfo['id']) {
            return true;
        }
    }
    return false;
}

/**
 * добавление задач в БД
 * @param $con mysqli Ресурс соединения
 * @param $sql запрос с плейсхолдерами вместо значений
 * @param name, date_creation, date_completion, file, project_id Данные для вставки на место плейсхолдеров
 * @return mysqli_stmt_execute($stmt)
 */
function addTaskform($con, $name, $dateCompletion, $file, int $projectId) {
    $sql = "
    INSERT INTO tasks (name, date_creation, date_completion, file, project_id) VALUES
    (?, NOW(), ?, ?, ?)";
    $stmt = db_get_prepare_stmt($con, $sql,  [$name, $dateCompletion, $file, $projectId]);
    return mysqli_stmt_execute($stmt);
}

/**
 * добавление проектов в БД
 * @param $con mysqli Ресурс соединения
 * @param $sql запрос с плейсхолдерами вместо значений
 * @param name, author_id Данные для вставки на место плейсхолдеров
 * @return mysqli_stmt_execute($stmt)
 */
function addProjectForm($con, $name, int $authorId) {
    $sql = "INSERT INTO projects ( name, author_id) VALUES (?, ?)";
    $stmt = db_get_prepare_stmt($con, $sql,  [$name, $authorId]);
    return mysqli_stmt_execute($stmt);
}

/** проверки формата даты
 * @param $date $format
 * @return format
 */
function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

/**
 * добавление пользователя в БД
 * @param $con mysqli Ресурс соединения
 * @param password_hash хеш пароля
 * @param $sql запрос с плейсхолдерами вместо значений
 * @param date_creation, email, name, password, token Данные для вставки на место плейсхолдеров
 * @return mysqli_stmt_execute($stmt)
 */
function addUser($con, $email, $name,  $password) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = 'INSERT INTO users (date_creation, email, name, password, token) VALUES (NOW(), ?, ?, ?, "")';
    $stmt = db_get_prepare_stmt($con, $sql, [$email, $name, $password]);
    return mysqli_stmt_execute($stmt);
}

/**
 * добавление пользователя в БД
 * @param $con mysqli Ресурс соединения
 * @param mysqli_real_escape_string Экранирует специальные символы в строке
 * @param $sql запрос на добавление пользователя
 * @return mysqli_query
 */
function getUserDataByEmail($con, $email) {
    $email = mysqli_real_escape_string($con, $email);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    return mysqli_query($con, $sql);
}

/**
 * изменение статуса задачи
 * @param $con mysqli Ресурс соединения
 * @param $sql запрос с плейсхолдерами вместо значений
 * @param $check, $taskId, $authorId Данные для вставки на место плейсхолдеров
 * @return mysqli_stmt_execute($stmt)
 */
function changeTaskCompletion($con, int $taskId, int $check, int $authorId) {
    $sql = "UPDATE tasks INNER JOIN projects ON projects.id = tasks.project_id
            SET tasks.done = ? WHERE tasks.id = ? AND projects.author_id = ?";
    $stmt = db_get_prepare_stmt($con, $sql, [$check, $taskId, $authorId]);
    return mysqli_stmt_execute($stmt);
}
