<?php

require_once 'init.php';

$error = '';

if (!$connect) {
    $error = 'Невозможно подключиться к базе данных: ' . mysqli_connect_error();
} else {
    $user_id = 1;
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
    $page_content = include_template('add_task.php', [
        'projects' => $projects
    ]);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form_task = $_POST;
    $errors = [];

    // проверяем заполнено ли поле "Название"

    $name = '';
    if (check_required($form_task['name'])) {
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
        if ($delta < 0) {
            $errors['date'] = 'Надо ввести дату в будущем';
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
            date('Y.m.d 23:59:59', strtotime($form_task['date'])),
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
]);

print($layout_content);
