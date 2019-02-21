<?php

require_once 'init.php';

$error = '';

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
    $form_task = $_POST; // копируем данные из формы в переменную

    $required = ['name'];   // список полей, которые надо валидировать
    $dict = ['name' => 'Название задачи'];  // описательное название для вывода ошибок
    $errors = [];

    foreach ($required as $key) {
        if (empty($_POST[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }

    if (isset($_FILES) && (!empty($_FILES['preview']['name']))) {
        $tmp_name = $_FILES['preview']['tmp_name'];
        $path = $_FILES['preview']['name'];
        move_uploaded_file($tmp_name, '/' . $path);
        $form_task['path'] = $path;
    } else {
        $page_content = include_template('add-task.php', ['projects' => $projects, 'errors' => $errors, 'dict' => $dict]);
    }

    if (count($errors)) {  // смотрим длину массива с ошибками
        $page_content = include_template('add.php', ['projects' => $projects, 'errors' => $errors, 'dict' => $dict]);
    } else {
        $page_content = include_template('index.php', [
            'show_complete_tasks' => $show_complete_tasks,
            'tasks' => $tasks
        ]);
    }
} else {
    $page_content = include_template('add-task.php', ['projects' => $projects]);
}

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'projects' => $projects,
    'tasks' => $tasks,
    'title' => 'Дела в порядке',
]);

print($layout_content);
