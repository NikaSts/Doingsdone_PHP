<?php

require_once 'init.php';

$is_auth = 0;
$user_name = '';

if (!empty($_SESSION['id'])) {
    $is_auth = 1;
    $user_name = $_SESSION['name'];
}

$error = '';

if (!$connect) {
    $error = 'Невозможно подключиться к базе данных: ' . mysqli_connect_error();
} else {
    $user_id = $_SESSION['id'];
    $sql_projects = 'SELECT * FROM projects WHERE user_id = ?';
    $projects = db_fetch_data($connect, $sql_projects, [$user_id]);

    $tasks = [];
    $project_id = intval($_GET['project_id']);

    $sql_tasks = 'SELECT * FROM tasks WHERE user_id = ?';
    $tasks = db_fetch_data($connect, $sql_tasks, [$user_id]);
}

if ($error) {
    $page_content = include_template('error.php', [
        'error' => $error
    ]);
} else {
    $page_content = include_template('add_project.php', []);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form_project = $_POST;
    $errors = [];

    // проверяем заполнено ли поле "Название"
    $name = '';
    if (empty($form_project['name'])) {
        $errors['name'] = 'Это поле надо заполнить';
    } else {
        $name = $form_project['name'];
    }

    // смотрим длину массива с ошибками
    if (count($errors) > 0) {
        $page_content = include_template('add_project.php', ['errors' => $errors]);
    } else {
        $sql = 'INSERT INTO projects ( name, user_id) VALUES (?, ?)';
        $result = db_insert_data($connect, $sql, [
            $name,
            $user_id
        ]);

        if ($result) {
            header('Location: /');
        }
    }

}

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'projects' => $projects,
    'tasks' => $tasks,
    'title' => 'Дела в порядке',
    'user_name' => $user_name
]);

print($layout_content);
