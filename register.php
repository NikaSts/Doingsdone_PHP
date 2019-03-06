<?php

require_once 'init.php';

if ($is_auth === 1) {
    header('Location: /');
}

$error = '';

if (!$connect) {
    $error = 'Невозможно подключиться к базе данных: ' . mysqli_connect_error();
    $page_content = include_template('error.php', [
        'error' => $error
    ]);
} else {
    $page_content = include_template('register.php', []);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_register = $_POST;
    $errors = [];

    //Проверяем поле email на ошибки

    if (empty($form_register['email'])) {
        $errors['email'] = 'Это поле надо заполнить';
    } else if (!filter_var($form_register['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'E-mail введён некорректно';
    } else {
        $email = $form_register['email'];
        $sql = "SELECT * FROM users WHERE email = ?";
        $matchFound = db_fetch_data($connect, $sql, [$email]);
        if ($matchFound) {
            $errors['email'] = 'Пользователь с таким e-mail уже существует';
        }
    }

    //Проверяем поле password на ошибки

    $passwordHash = '';

    if (empty($form_register['password'])) {
        $errors['password'] = 'Это поле надо заполнить';
    } else {
        $password = trim($form_register['password']);
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }

    //Проверяем поле name на ошибки

    if (empty($form_register['name'])) {
        $errors['name'] = 'Это поле надо заполнить';
    }


    if (count($errors) > 0) {
        $page_content = include_template('register.php', ['errors' => $errors]);
    } else {
        $sql = 'INSERT INTO users (signed_up, email, name, password) VALUES (NOW(), ?, ?, ?)';
        $result = db_insert_data($connect, $sql, [
            $form_register['email'],
            $form_register['name'],
            $passwordHash
        ]);
    }

    if (isset($result)) {
        header('Location: /auth.php');
    }
}

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'title' => 'Форма регистрации',
    'sidebar' => true,
    'is_auth' => $is_auth
]);

print($layout_content);
