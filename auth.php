<?php

require_once 'init.php';

session_start();
$is_auth = 0;
$user_name = '';

if (!empty($_SESSION['id'])) {
    $is_auth = 1;
}

$error = '';

if (!$connect) {
    $error = 'Невозможно подключиться к базе данных: ' . mysqli_connect_error();
    $page_content = include_template('auth.php', [
        'error' => $error
    ]);
} else {
    $page_content = include_template('auth.php', []);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $form_auth = $_POST;
    $required = ['email', 'password'];
    $errors = [];

    foreach ($required as $key) {
        if (empty($form_auth[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }

    $email = $form_auth['email'];
    $sql = "SELECT * FROM users WHERE email = ?";
    $matchFound = db_fetch_data($connect, $sql, [$email]);

    if (!count($errors) && $matchFound) {
        if (password_verify($form_auth['password'], $matchFound[0]['password'])) {
            $_SESSION = $matchFound[0];
        } else {
            $errors['password'] = 'Введен неверный пароль';
        }
    } else {
        $errors['email'] = 'Пользователя с таким e-mail нет на сайте';
    }


    if (count($errors)) {
        $page_content = include_template('auth.php', ['form' => $form_auth, 'errors' => $errors]);
    } else {
        header("Location: /");
        exit();  // такой везде надо добавить?
    }
}

/*
if (!filter_var($form_auth['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'E-mail введён некорректно';
    $errors['password'] = false;
} else {
    $email = $form_auth['email'];
    $sql = "SELECT * FROM users WHERE email = ?";
    $matchFound = db_fetch_data($connect, $sql, [$email]);
    foreach ($matchFound as $keys) {
        $password = $matchFound[0]['password'];
    }
    if (!$matchFound) {
        $errors['email'] = 'Пользователя с таким e-mail нет на сайте';
        $errors['password'] = false;
    } else if ($matchFound && !password_verify(trim($matchFound['password']), $form_auth['password'])) {
        $errors['password'] = 'Введен неверный пароль';
    }
*/

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'projects' => $projects,
    'tasks' => $tasks,
    'title' => 'Дела в порядке',
    'user_name' => $user_name,
    'is_auth' => $is_auth
]);

print($layout_content);
