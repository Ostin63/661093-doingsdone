<?php
// подключаем файлы
require_once('connect.php');
require_once('functions.php');
require_once('vendor/autoload.php');


$transport = new Swift_SmtpTransport("phpdemo.ru", 25);
$transport->setUsername("keks@phpdemo.ru");
$transport->setPassword("htmlacademy");

$mailer = new Swift_Mailer($transport);

$logger = new Swift_Plugins_Loggers_ArrayLogger();
$mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

foreach (getHotTasks($con) as $task) {
    $email = $task['user_email'];
    $userName = $task['user_name'];
    $date = $task['date_completion'];
    $taskName = $task['name'];
}

$message = new Swift_Message();
$message->setSubject('Уведомление от сервиса «Дела в порядке»');
$message->setFrom(['keks@phpdemo.ru' => 'Дела в порядке']);
$message->setBcc([$email => $userName]);
$message->setBody("Уважаемый, $userName. У вас запланирована задача $taskName на $date");
$message->setContentType('text/plain');
$mailer->send($message);
