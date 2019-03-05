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

if (!$connect) {
    $error = 'Невозможно подключиться к базе данных: ' . mysqli_connect_error();
} else {
    $user_id = $_SESSION['id'];
    $sql_projects = "SELECT *, (SELECT COUNT(*) FROM tasks as t WHERE t.project_id=projects.id) as cnt FROM projects WHERE user_id = ?";
    $projects = db_fetch_data($connect, $sql_projects, [$user_id]);

    $tasks = [];
    if (isset($_GET['project_id'])) {
        $project_id = intval($_GET['project_id']);
    }

    $sql_tasks = 'SELECT * FROM tasks WHERE user_id = ?';
    $tasks = db_fetch_data($connect, $sql_tasks, [$user_id]);
}

if ($error) {
    $page_content = include_template('error.php', [
        'error' => $error
    ]);
} else {
    $page_content = include_template('add_task.php', [
        'projects' => $projects
    ]);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form_task = $_POST;
    $errors = [];

    // проверяем заполнено ли поле "Название"

    $name = '';
    if (empty($form_task['name'])) {
        $errors['name'] = 'Это поле надо заполнить';
    } else {
        $name = $form_task['name'];
    }

    // проверяем, выбран ли проект

    $project_id = false;
    foreach ($projects as $project) {
        if ($form_task['project'] == $project['id']) {
            $project_id = intval($form_task['project']);
        }
    }
    if (!$project_id) {
        $errors['project'] = 'Надо выбрать проект';
    }

    // проверяем, правильная ли введена дата

    if (!empty($form_task['date'])) {
        $delta = strtotime($form_task['date']) - strtotime(date('d.m.Y 00:00:00'));
        if ($delta < 0 || !check_date_format($form_task['date'])) {
            $errors['date'] = 'Надо ввести дату в правильном формате';
        }
    }

    // проверяем, прикреплен ли файл

    $path = '';
    if (!empty($_FILES['preview']['name'])) {
        $tmp_name = $_FILES['preview']['tmp_name'];
        $path = $_FILES['preview']['name'];

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $path = '' . uniqid() . "." . $ext;
        move_uploaded_file($tmp_name, '' . $path);
    }

    // смотрим длину массива с ошибками
    if (count($errors) > 0) {
        $page_content = include_template('add_task.php', ['projects' => $projects, 'errors' => $errors]);
    } else {
        $sql = 'INSERT INTO tasks ( name, project_id, file_link, time_limit, is_created, user_id) VALUES (?, ?, ?, ?, now(), ?)';
        $result = db_insert_data($connect, $sql, [
            $form_task['name'],
            $project_id,
            $path,
            date('Y.m.d 00:00:00', strtotime($form_task['date'])),
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
    'user_name' => $user_name,
    'sidebar' => true,
    'is_auth' => $is_auth
]);

print($layout_content);
