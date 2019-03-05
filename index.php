<?php
require_once 'init.php';

$is_auth = 0;
$user_name = '';

if (isset($_SESSION['id'])) {
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
    $sql_projects = "SELECT *, (SELECT COUNT(*) FROM tasks as t WHERE t.project_id=projects.id) as cnt FROM projects WHERE user_id = ?";
    $projects = db_fetch_data($connect, $sql_projects, [$user_id]);

    if (isset($_GET['project_id'])) {
        $project_id = intval($_GET['project_id']);
    }

    //показывать ли выполненные задачи
    $show_complete_tasks = 0;
    if (isset($_GET['show_completed'])) {
        $show_complete_tasks = intval($_GET['show_completed']);
    }

    //выполнение задачи
    if (isset($_GET['task_id']) && isset($_GET['check'])) {
        if ($task_id = intval($_GET['task_id'])) {
            $task = db_fetch_data($connect, "SELECT now_status FROM tasks WHERE id = ?", [$task_id])[0];
            if ($task) {
                $sql_close_task = "UPDATE tasks SET now_status = ?, is_done = NOW() WHERE id = ?";
                db_insert_data($connect, $sql_close_task, [(string)!$task['now_status'], $task_id]);
            }
        }
    }

    //получение списка задач пользователя
    $sql_tasks = "SELECT * FROM tasks WHERE user_id = ? ORDER BY id DESC";
    if (isset($_GET['tasks_switch'])) {
        switch ($_GET['tasks_switch']) {
            case 'today':
                $sql_tasks = "SELECT * FROM tasks WHERE time_limit >= DATE_FORMAT(NOW(), '%Y-%m-%d 00:00:00') AND time_limit <= DATE_FORMAT(NOW(), '%Y-%m-%d 23:59:59') AND user_id = ? ORDER BY id DESC";
                break;
            case 'tomorrow':
                $sql_tasks = "SELECT * FROM tasks WHERE time_limit >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL -1 DAY), '%Y-%m-%d 00:00:00') AND time_limit <= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL -1 DAY), '%Y-%m-%d 23:59:59') AND user_id = ? ORDER BY id DESC";
                break;
            case 'overdue':
                $sql_tasks = "SELECT * FROM tasks WHERE time_limit > '1970-01-01 23:59:59' AND time_limit < NOW() AND user_id = ? ORDER BY id DESC";
                break;
        }
    }

    $tasks = db_fetch_data($connect, $sql_tasks, [$user_id]);
    if (isset($_GET['project_id']) && !$project_id) {
        $error = '404';
        http_response_code(404);
    }
}

if ($error) {
    $page_content = include_template('error.php', [
        'error' => $error
    ]);
} else {
    if ($is_auth) {
        $tasks_menu = require_once 'index_tasks_menu.php';
        $page_content = include_template('index.php', [
            'show_complete_tasks' => $show_complete_tasks,
            'tasks_menu' => $tasks_menu,
            'tasks' => $tasks
        ]);
    } else {
        $page_content = include_template('guest.php', []);
    }
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
