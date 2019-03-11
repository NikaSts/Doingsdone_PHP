<?php

require_once 'init.php';

if ($is_auth !== 1 || !$user_id) {
    header('Location: /');
}

$projects = [];
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
    $page_content = include_template('add_task.php', [
        'projects' => $projects
    ]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_task = $_POST;
    $errors = [];

    // проверяем заполнено ли поле 'Название'

    $name = '';
    if (empty($form_task['name'])) {
        $errors['name'] = 'Это поле надо заполнить';
    } else {
        $name = $form_task['name'];
    }

    // если выбран проект, проверяем его

    $project_id = 0;
    if (!empty($form_task['project'])) {
            if (In_array($form_task['project'], array_column($projects, 'id'))) {
                $project_id = intval($form_task['project']);
            } else {
                $errors['project'] = 'Такого проекта не существует';
            }
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
        $path = uniqid() . '.' . $ext;
        move_uploaded_file($tmp_name, '' . $path);
    }

    // смотрим длину массива с ошибками
    if (count($errors) > 0) {
        $page_content = include_template('add_task.php', ['projects' => $projects, 'errors' => $errors]);
    } else {
        $sql = 'INSERT INTO tasks (name, project_id, file_link, time_limit, is_created, user_id) VALUES (?, ?, ?, ?, now(), ?)';
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
    'title' => 'Дела в порядке',
    'sidebar' => true,
    'is_auth' => $is_auth
]);

print($layout_content);
