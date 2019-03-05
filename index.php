<?php

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
$filters = [];

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

    if (isset($_GET['filter_task'])) {
        $filter_task = $_GET['filter_task'];
        if ($filter_task = 'today') {
            $from = date('Y-m-d 00:00:00, strtotime(now)');
            $to = date('Y-m-d 00:00:00, strtotime(+1 day)');
            $sql = 'SELECT * FROM tasks WHERE time_limit >= ? AND time_limit < ?';
            db_fetch_data($connect, $sql, [$from, $to]);
        } else if ($filter_task = 'tomorrow') {
            $from = date('Y-m-d 00:00:00, strtotime(+1 day)');
            $to = date('Y-m-d 00:00:00, strtotime(+2 day)');
            $sql = 'SELECT * FROM tasks WHERE time_limit >= ? AND time_limit < ?';
            db_fetch_data($connect, $sql, [$from, $to]);
        } else if ($filter_task = 'overdue') {
            $to = date('Y-m-d 00:00:00, strtotime(to)');
            $sql = 'SELECT * FROM tasks WHERE time_limit > "1970-01-01 23:59:59" AND time_limit < ? AND is_done IS NULL';
            db_fetch_data($connect, $sql, [$to]);
        }
    }

    $show_complete_tasks = 0;

    if (isset($_GET['show_completed'])) {
        $show_complete_tasks = intval($_GET['show_completed']);
    }
    //   $task_id = '';
    if (isset($_GET['task_id']) && isset($_GET['check'])) {
        $task_id = intval($_GET['task_id']);
    }
    if (isset($_GET['check']) && ($_GET['check'] == 1)) {
        $sql = "UPDATE tasks SET is_done = now(), now_status = '1' WHERE id = ?";
        db_fetch_data($connect, $sql, [$task_id]);
    }
    if (isset($_GET['check']) && ($_GET['check'] == 0)) {
        $sql = "UPDATE tasks SET is_done = NULL, now_status = '0' WHERE id = ?";
        db_fetch_data($connect, $sql, [$task_id]);
    }
}

/*
 * if (isset($_GET['task_id']) && isset($_GET['check'])) {
        $task_id = intval($_GET['task_id']);
        $checked = intval($_GET['check']);
        $is_done = '';
        if ($checked == 1) {
            $is_done = 'now()';
        } else {
            $is_done = 'NULL';
        }
        $sql = "UPDATE tasks SET is_done = ?, now_status = ? WHERE id = ?";
        $result = db_fetch_data($connect, $sql, [$is_done, $checked, $task_id]);
    }
 */

if ($error) {
    $page_content = include_template('error.php', [
        'error' => $error
    ]);
} else {
    $page_content = include_template($is_auth ? 'index.php' : 'guest.php', [
        'show_complete_tasks' => $show_complete_tasks,
        'tasks' => $tasks,
    ]);
}


$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'projects' => $projects,
    'tasks' => $tasks,
    'title' => 'Дела в порядке',
    'user_name' => $user_name,
    'sidebar' => !!$is_auth,
    'is_auth' => $is_auth
]);

print($layout_content);
