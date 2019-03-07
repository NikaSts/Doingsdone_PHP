<?php

require_once('init.php');


$transport = new Swift_SmtpTransport("phpdemo.ru", 25);
$transport->setUsername("keks@phpdemo.ru");
$transport->setPassword("htmlacademy");

$mailer = new Swift_Mailer($transport);

$logger = new Swift_Plugins_Loggers_ArrayLogger();
$mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

$sql = "SELECT tasks.name AS title, tasks.time_limit AS time_limit, users.name AS name, users.email AS email 
FROM tasks JOIN users ON tasks.user_id = users.id 
WHERE tasks.now_status = '0' AND tasks.time_limit = CURRENT_DATE() AND YEAR(tasks.time_limit) > '1970' 
GROUP BY user_id";

$result = mysqli_query($connect, $sql);

if ($result && mysqli_num_rows($result)) {
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $recipients = [];
    foreach ($tasks as $key => $val) {
        $recipients[$val['email']] = $val['name'];

        $message = new Swift_Message();
        $message->setSubject("Уведомление от сервиса «Дела в порядке»");
        $message->setFrom(['keks@phpdemo.ru' => 'DoingsDone']);
        $message->setTo($recipients);

 //       $message_content = "'<b>Уважаемый, ' . $val['name'] . '.'<b><br><p>У вас запланирована задача ' . $val['title'] . 'на ' . $val['time_limit'] . '.'</p>";
    $message->addPart($message_content, 'text/html');

    $result = $mailer->send($message);

    if ($result) {
        print("Рассылка успешно отправлена");
    } else {
        print("Не удалось отправить рассылку: " . $logger->dump());
    }
}
}

