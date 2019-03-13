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
        $users[$key['id']]['tasks'][] = [
            'title' => $key['title'],
            'time_limit' => $key['time_limit']
        ];
    }

    //перебираем массив подставляя значения в письмо
    foreach ($users as $user) {
        $message = new Swift_Message();
        $message->setSubject("Уведомление от сервиса «Дела в порядке»");
        $message->setFrom(['keks@phpdemo.ru' => 'DoingsDone']);
        $message->setTo($user['email']);

        $message_content = 'Уважаемый, ' . $user['name'] .'<br>';

        foreach ($user['tasks'] as $task) {
            $message_content .= 'У вас запланирована задача: ';
            $message_content .=  $task['title'];
            $message_content .= ' на ' . date('d.m.Y', strtotime($task['time_limit']));
            $message_content .= '<br>';
        }

        $message->addPart($message_content . '<br>', 'text/html');
    }

    $result = $mailer->send($message);

    if ($result) {
        print("Рассылка успешно отправлена");
    } else {
        print("Не удалось отправить рассылку: " . $logger->dump());
    }
}
