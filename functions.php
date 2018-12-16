<?php
require_once('mysql_helper.php');

/**
 * Получение проектов для одного автора
 * @param $con mysqli Ресурс соединения
 * @param $userId int Данные для вставки на место плейсхолдеров
 * @return array
 */
function getProjects($con, int $userId)
{
    $sql = "SELECT * FROM projects WHERE author_id = ?";
    $stmt = db_get_prepare_stmt($con, $sql, [$userId]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $projects = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $projects;
}

/**
 * Получение имен категорий для одного автора
 * @param $con mysqli Ресурс соединения
 * @param $userId id Данные для вставки на место плейсхолдеров
 * @return array
 */
function getTasksForAuthorId($con, int $userId)
{
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
 * Получение всех задач для одного автора
 * @param $con mysqli Ресурс соединения
 * @param $userId int Данные для вставки на место плейсхолдеров
 * @return array
 */
function getTasksForAuthorIdAllProjected($con, int $userId)
{
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
 * Получение задач на сегодня для одного автора
 * @param $con mysqli Ресурс соединения
 * @param $userId int Данные для вставки на место плейсхолдеров
 * @return array
 */
function getTasksForAuthorIdAndProjectedAgenda($con, int $userId)
{
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
 * Получение задач на завтра для одного автора
 * @param $con mysqli Ресурс соединения
 * @param $userId int Данные для вставки на место плейсхолдеров
 * @return array
 */
function getTasksForAuthorIdAndProjectedTomorrow($con, int $userId)
{
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
 * Получение просроченных задач для одного автора
 * @param $con mysqli Ресурс соединения
 * @param $userId int Идентификатор автора
 * @return array
 */
function getTasksForAuthorIdAndProjectedExpired($con, int $userId)
{
    $sql = "
            SELECT DISTINCT tasks. * , projects.name AS project_name
            FROM tasks
            INNER JOIN projects ON tasks.project_id = projects.id
            WHERE projects.author_id = ?
              AND tasks.date_completion < NOW()";
    $stmt = db_get_prepare_stmt($con, $sql, [$userId]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $tasksList = mysqli_fetch_all($res, MYSQLI_ASSOC);
    return $tasksList;
}

/**
 * Получение задач проекта для одного автора
 * @param $con mysqli Ресурс соединения
 * @param $userId int Данные для вставки на место плейсхолдеров
 * @param $projectId int Данные для вставки на место плейсхолдеров
 * @return array
 */
function getTasksForAuthorIdAndProjected($con, int $userId, int $projectId)
{
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
 * "Поле поиска" задач для одного автора
 * @param $con mysqli Ресурс соединения
 * @param $search Данные для вставки на место плейсхолдеров
 * @param $userId int Данные для вставки на место плейсхолдеров
 * @return array
 */
function searchTaskAuthor($con, $search, int $userId)
{
    $sql = "SELECT tasks.*, projects.name AS project_name FROM tasks
            JOIN projects ON projects.id = tasks.project_id
		    WHERE MATCH(tasks.name) AGAINST(?) AND projects.author_id = ?";
    $stmt = db_get_prepare_stmt($con, $sql, [$search, $userId]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Получение задач по фильтрации для одного автора
 * @param $con mysqli Ресурс соединения
 * @param $userId int обработка параметров
 * @param $projectId int обработка параметров
 * @param $search обработка параметров
 * @param $filter обработка параметров
 * @return array
 */
function getTasksForAuthorIdAndProjectedFilter($con, int $userId, int $projectId = null, $filter = null, $search = null)
{
    if (!empty($projectId)) {
        return getTasksForAuthorIdAndProjected($con, (int)$userId, (int)$projectId);
    } else if (!empty($search)) {
        return searchTaskAuthor($con, $search, (int)$userId);
    } else {
        switch ($filter) {
            case 'agenda' :
                return getTasksForAuthorIdAndProjectedAgenda($con, (int)$userId);
            case 'tomorrow' :
                return getTasksForAuthorIdAndProjectedTomorrow($con, (int)$userId);
            case 'expired' :
                return getTasksForAuthorIdAndProjectedExpired($con, (int)$userId);
            default :
                return getTasksForAuthorIdAllProjected($con, (int)$userId);
        }
    }
}

/**
 * Подсчитывает колличество задач по категориям для одного автора
 * @param $tasksList array список задач
 * @param $projectId int список проуктов
 * @return int
 */
function countTasks(array $tasksList, int $projectId)
{
    $tasksAmount = 0;
    foreach ($tasksList as $task) {
        if ($task['project_id'] === $projectId) {
            $tasksAmount++;
        }
    }
    return $tasksAmount;
}

/**
 * Подсчитывает остатк времени до выполнения задачи
 * @param $taskDate дата выполнения задачи
 * @param $importantHours остаток времени
 * @return int
 */
function isTaskImportant($taskDate, $importantHours)
{
    if (empty($taskDate)) return false;
    $seconds_in_hour = 3600;
    $ts = time();
    $end_ts = strtotime($taskDate);
    $ts_diff = $end_ts - $ts;
    return floor($ts_diff / $seconds_in_hour) <= $importantHours;
}

/**
 * Определяет существованЯ id пользователя
 * @param $id int БД авторов
 * @param $entityList введенние данные
 * @return boolean
 */
function idExists(int $id, array $entityList)
{
    foreach ($entityList as $entityInfo) {
        if ($id == $entityInfo['id']) {
            return true;
        }
    }
    return false;
}

/**
 * Добавление задач в БД
 * @param $con mysqli Ресурс соединения
 * @param $name Данные для вставки на место плейсхолдеров
 * @param $dateCompletion Данные для вставки на место плейсхолдеров
 * @param $file Данные для вставки на место плейсхолдеров
 * @param $projectId int Данные для вставки на место плейсхолдеров
 * @return array
 */
function addTaskform($con, $name, $dateCompletion, $file, int $projectId)
{
    $sql = "
    INSERT INTO tasks (name, date_creation, date_completion, file, project_id) VALUES
    (?, NOW(), ?, ?, ?)";
    $stmt = db_get_prepare_stmt($con, $sql, [$name, $dateCompletion, $file, $projectId]);
    return mysqli_stmt_execute($stmt);
}

/**
 * Добавление проектов в БД
 * @param $con mysqli Ресурс соединения
 * @param $name Данные для вставки на место плейсхолдеров
 * @return array
 */
function addProjectForm($con, $name, int $authorId)
{
    $sql = "INSERT INTO projects ( name, author_id) VALUES (?, ?)";
    $stmt = db_get_prepare_stmt($con, $sql, [$name, $authorId]);
    return mysqli_stmt_execute($stmt);
}

/**
 * Проверка формата даты
 * @param $date исходное написпние
 * @param $format желаемый вид
 * @return string
 */
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

/**
 * Добавление пользователя в БД
 * @param $con mysqli Ресурс соединения
 * @param $password Данные для вставки на место плейсхолдеров
 * @param $email Данные для вставки на место плейсхолдеров
 * @param $name  Данные для вставки на место плейсхолдеров
 * @return array
 */
function addUser($con, $email, $name, $password)
{
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = 'INSERT INTO users (date_creation, email, name, password, token) VALUES (NOW(), ?, ?, ?, "")';
    $stmt = db_get_prepare_stmt($con, $sql, [$email, $name, $password]);
    return mysqli_stmt_execute($stmt);
}

/**
 * Проверка email пользователя
 * @param $con mysqli Ресурс соединения
 * @param $email
 * @return array
 */
function getUserDataByEmail($con, $email)
{
    $email = mysqli_real_escape_string($con, $email);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    return mysqli_query($con, $sql);
}

/**
 * Изменение статуса задачи
 * @param $con mysqli Ресурс соединения
 * @param $taskId int Данные для вставки на место плейсхолдеров
 * @param $check int Данные для вставки на место плейсхолдеров
 * @param $authorId int Данные для вставки на место плейсхолдеров
 * @return array
 */
function changeTaskCompletion($con, int $taskId, int $check, int $authorId)
{
    $sql = "UPDATE tasks INNER JOIN projects ON projects.id = tasks.project_id
            SET tasks.done = ? WHERE tasks.id = ? AND projects.author_id = ?";
    $stmt = db_get_prepare_stmt($con, $sql, [$check, $taskId, $authorId]);
    return mysqli_stmt_execute($stmt);
}

/**
 * Вызов задач на завтра + 1час для email автора
 * @param $con mysqli Ресурс соединения
 * @return array
 */
function getHotTasks($con)
{
    $sql = "
            SELECT DISTINCT
              tasks.date_completion,
              tasks.name,
              users.email AS user_email,
              users.name AS user_name
            FROM tasks
            INNER JOIN projects ON tasks.project_id = projects.id
            INNER JOIN users ON projects.author_id = users.id
            WHERE tasks.date_completion BETWEEN NOW() AND DATE_ADD(now(), INTERVAL 1 HOUR)";
    $res = mysqli_query($con, $sql);
    return mysqli_fetch_all($res, MYSQLI_ASSOC);
}
