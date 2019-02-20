<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

require_once 'init.php';

print_r($_GET);

$error = [];

if (!$connect) {
    $error = 'Невозможно подключиться к базе данных: ' . mysqli_connect_error();
} else {
    $user_id = 1;
    $sql_projects = "SELECT * FROM projects WHERE user_id = ?";
    $projects = db_fetch_data($connect, $sql_projects, [$user_id]);

    $tasks = [];
    $project_id = intval($_GET['project_id']);

    $sql_tasks = "SELECT * FROM tasks WHERE user_id = ?";
    $tasks = db_fetch_data($connect, $sql_tasks, [$user_id]);

    if (isset($_GET['project_id']) && !$project_id) {
        $error = '404';
    } else if ($project_id) {
        $sql_tasks_count = "SELECT COUNT(*) as count FROM tasks WHERE user_id = ? AND project_id = ?";
        $task_count = db_fetch_data($connect, $sql_tasks_count, [$user_id, $project_id]);
        if (!$task_count[0]['count']) {
            $error = '404';
        }
    }
    if ($error) {
        $page_content = include_template('error.php', [
            'error' => $error
        ]);
    } else {
        $page_content = include_template('index.php', [
            'show_complete_tasks' => $show_complete_tasks,
            'tasks' => $tasks
        ]);
    }
}


$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'projects' => $projects,
    'tasks' => $tasks,
    'title' => 'Дела в порядке',
]);

print($layout_content);





