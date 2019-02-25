<?php

require_once 'init.php';

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
    $errors = [];
    $matchFound = [];


    if (empty($form_register['password'])) {
        $errors['password'] = 'Это поле надо заполнить';
    }

    if (empty($form_auth['email'])) {
        $errors['email'] = 'Это поле надо заполнить';
    } else if (!filter_var($form_auth['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'E-mail введён некорректно';
        $errors['password'] = false;
    } else {
        $email = $form_auth['email'];
        $sql = "SELECT * FROM users WHERE email = ?";
        $matchFound = db_fetch_data($connect, $sql, [$email]);
        foreach ($matchFound as $keys) {
            $password = $matchFound['password'];
        }
        if (!$matchFound) {
            $errors['email'] = 'Пользователя с таким e-mail нет на сайте';
            $errors['password'] = false;
        } else if ($matchFound && password_verify(trim($matchFound['password']), $form_auth['password'])) {
            $errors['password'] = 'Введен неверный пароль';
        } else {
           $_SESSION['user'] = $matchFound;
        }
    }

    if (count($errors) > 0) {
        $page_content = include_template('auth.php', ['errors' => $errors]);
    } else {
        $_SESSION['user'] = $matchFound;
    }
}

print_r($matchFound);

$layout_content = include_template('layout_non_auth.php', [
    'page_content' => $page_content,
    'title' => 'Форма авторизации',
]);


print($layout_content);
