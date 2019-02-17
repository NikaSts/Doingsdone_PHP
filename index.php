<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/config.php');




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

