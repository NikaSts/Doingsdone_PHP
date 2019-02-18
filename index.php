<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

require_once 'init.php';

if (!$connect) {
    print('Невозможно подключиться к базе данных: ' . mysqli_connect_error());
} else {
    $sql1 = "SELECT * FROM projects";
    $sql2 = "SELECT * FROM tasks";

    $projects = db_fetch_data($connect, $sql1);
    $tasks = db_fetch_data($connect, $sql2);
}
$page_content = include_template('index.php', [
    'show_complete_tasks' => $show_complete_tasks,
    'tasks' => $tasks
]);

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'projects' => $projects,
    'tasks' => $tasks,
    'title' => 'Дела в порядке'
]);
print($layout_content);




