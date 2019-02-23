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

    $required = ['name'];

    foreach ($required as $key) {
        if (empty($required[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }

    // проверяем, выбран ли проект

    foreach ($projects as $key) {
        if ($form_task['project'] === $projects['name']) {
            $project_id = $projects['id'];
        } else {
            $errors['project'] = 'Не выбран проект';
        }
    }


    // проверяем, правильная ли введена дата

    if (isset($form_task['date'])) {
        $delta = strtotime($form_task['date']) - strtotime(now);
        if ($delta<0) {
            $delta = false;
            $errors['date'] = 'Введена дата в прошлом';
        }
    }

    // проверяем, прикреплен ли файл

    if (!empty($_FILES['preview']['name'])) {
        $tmp_name = $_FILES['preview']['tmp_name'];
        $path = $_FILES['preview']['name'];
        move_uploaded_file($tmp_name, '' . $path);
        $form_task['path'] = $path;
    }

    if (count($errors)) {  // смотрим длину массива с ошибками
        $page_content = include_template('add_task.php', ['projects' => $projects, 'errors' => $errors, 'dict' => $dict]);
    } else {
        $page_content = include_template('index.php', [
            'show_complete_tasks' => $show_complete_tasks,
            'tasks' => $tasks
        ]);
    }

        $sql = 'INSERT INTO tasks ( name, project_id, file_link, time_limit) VALUES (?, ?, ?, ?)';
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, 'siss', $form_task['name'], $project_id, $form_task['preview'], $form_task['date']);
        $result = mysqli_stmt_execute($stmt);
    }

    if ($result) {
        $page_content = include_template('index.php', [
            'show_complete_tasks' => $show_complete_tasks,
            'tasks' => $tasks
        ]);
    } else {
        $page_content = include_template('add_task.php', ['projects' => $projects, 'errors' => $errors, 'dict' => $dict]);
    }



$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'projects' => $projects,
    'tasks' => $tasks,
    'title' => 'Дела в порядке',
]);

print_r($_POST);
print_r($errors);

print($layout_content);
