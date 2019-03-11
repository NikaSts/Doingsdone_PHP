<?php

require_once('init.php');

$transport = new Swift_SmtpTransport("phpdemo.ru", 25);
$transport->setUsername("keks@phpdemo.ru");
$transport->setPassword("htmlacademy");

$mailer = new Swift_Mailer($transport);

$logger = new Swift_Plugins_Loggers_ArrayLogger();
$mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

//получаем пользователей с истекающими задачами
$sql = "SELECT users.id, users.name, users.email, tasks.name AS title, tasks.time_limit 
FROM users JOIN tasks ON tasks.user_id = users.id 
WHERE tasks.now_status = '0' AND tasks.time_limit = CURRENT_DATE()";

$res = db_fetch_data($connect, $sql, []);

if ($res) {
    $users = [];

    //формируем массив с данными пользователя
    foreach ($res as $key) {
        $users[$key['id']]['name'] = $key['name'];
        $users[$key['id']]['email'] = $key['email'];
        $users[$key['id']]['time_limit'] = $key['time_limit'];
        $users[$key['id']]['tasks'][] = $key['title'];
    }

    //перебираем массив подставляя значения в письмо
    foreach ($users as $user) {
        $message = new Swift_Message();
        $message->setSubject("Уведомление от сервиса «Дела в порядке»");
        $message->setFrom(['keks@phpdemo.ru' => 'DoingsDone']);
        $message->setTo($user['email']);

        $greeting = 'Уважаемый, ' . $user['name'];
        $text_body = 'У вас запланирована задача: ';
        $date = 'на' . $user['time_limit'];
        $task = '';
        $message_content = '';
        foreach ($tasks as $task) {
            $message_content = $greeting . $text_body . $task . $date;
                $message->addPart($message_content, 'text/html');
        }
    }
    $result = $mailer->send($message);

    if ($result) {
        print("Рассылка успешно отправлена");
    } else {
        print("Не удалось отправить рассылку: " . $logger->dump());
    }
}


