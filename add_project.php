<?php

require_once 'init.php';

if ($is_auth !== 1 || !$user_id) {
    header('Location: /');
}

$error = '';

if (!$connect) {
    $error = 'Невозможно подключиться к базе данных: ' . mysqli_connect_error();
} else {
    $projects = get_projects($connect, $user_id);
}

if ($error) {
    $page_content = include_template('error.php', [
        'error' => $error
    ]);
} else {
    $page_content = include_template('add_project.php', []);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_project = $_POST;
    $errors = [];

    // проверяем заполнено ли поле 'Название'
    $name = '';
    if (empty($form_project['name'])) {
        $errors['name'] = 'Это поле надо заполнить';
    } else {
        $name = $form_project['name'];

        $sql = 'SELECT * FROM projects WHERE name = ? AND user_id = ?';
        $matchFound = db_fetch_data($connect, $sql, [$name, $user_id]);
        if ($matchFound) {
            $errors['name'] = 'Такой проект уже существует';
        }
    }

    // смотрим длину массива с ошибками
    if (count($errors) > 0) {
        $page_content = include_template('add_project.php', ['errors' => $errors]);
    } else {
        $sql = 'INSERT INTO projects (name, user_id) VALUES (?, ?)';
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
    'title' => 'Дела в порядке',
    'sidebar' => true,
    'is_auth' => $is_auth
]);

print($layout_content);
