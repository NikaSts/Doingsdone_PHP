<?php

require_once 'init.php';

if ($is_auth === 1) {
    header('Location: /');
}

$sidebar = false;

$error = '';

if (!$connect) {
    $error = 'Невозможно подключиться к базе данных: ' . mysqli_connect_error();
    $page_content = include_template('auth.php', [
        'error' => $error
    ]);
} else {
    $page_content = include_template('auth.php', []);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_auth = $_POST;
    $required = ['email', 'password'];
    $errors = [];

    foreach ($required as $key) {
        if (empty($form_auth[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }

    $email = $form_auth['email'];
    $sql = 'SELECT * FROM users WHERE email = ?';
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
        header('Location: /');
        exit();
    }
}

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Дела в порядке',
    'sidebar' => true,
    'is_auth' => $is_auth
]);

print($layout_content);
