<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

require_once 'init.php';
require_once 'functions.php';

if (!$connect) {
    print('Невозможно подключиться к базе данных: ' . mysqli_connect_error());
}
else {
    $sql1 = "SELECT * FROM projects";
    $sql2 = "SELECT * FROM tasks";

    $result1 = mysqli_query($connect, $sql1);
    $result2 = mysqli_query($connect, $sql2);

    if ($result1 && $result2){
        $projects = mysqli_fetch_all($result1, MYSQLI_ASSOC);
        $tasks = mysqli_fetch_all($result2, MYSQLI_ASSOC);
    }
    else {
        $error = mysqli_error($connect);
        $page_content = include_template('error.php', [
            'error' => $error
        ]);
    }
};

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




