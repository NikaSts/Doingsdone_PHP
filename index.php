<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

require_once 'init.php';

$is_auth = 0;
$user_name = '';

if (!empty($_SESSION['id'])) {
    $is_auth = 1;
    $user_name = $_SESSION['name'];
}

$projects = [];
$tasks = [];
$error = '';

if (!$connect) {
    $error = 'Невозможно подключиться к базе данных: ' . mysqli_connect_error();
} else if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    $sql_projects = "SELECT * FROM projects WHERE user_id = ?";
    $projects = db_fetch_data($connect, $sql_projects, [$user_id]);

    $tasks = [];
    if (isset($_GET['project_id'])) {
        $project_id = intval($_GET['project_id']);
    }

    $sql_tasks = "SELECT * FROM tasks WHERE user_id = ? ORDER BY id DESC";
    $tasks = db_fetch_data($connect, $sql_tasks, [$user_id]);
    if (isset($_GET['project_id']) && !$project_id) {
        $error = '404';
        http_response_code(404);
    } else if (isset($project_id)) {
        $sql_tasks_count = "SELECT COUNT(*) as count FROM tasks WHERE user_id = ? AND project_id = ?";
        $task_count = db_fetch_data($connect, $sql_tasks_count, [$user_id, $project_id]);
        if (!$task_count[0]['count']) {
            $error = '404';
            http_response_code(404);
        }
    }
}

if ($error) {
    $page_content = include_template('error.php', [
        'error' => $error
    ]);
} else {
    $page_content = include_template($is_auth ? 'index.php' : 'guest.php', [
        'show_complete_tasks' => $show_complete_tasks,
        'tasks' => $tasks
    ]);
}


$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'projects' => $projects,
    'tasks' => $tasks,
    'title' => 'Дела в порядке',
    'user_name' => $user_name,
    'sidebar' => true,
    'is_auth' => $is_auth
]);


print($layout_content);
