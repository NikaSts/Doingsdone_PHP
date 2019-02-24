<?php

require_once 'init.php';

$error = '';

if (!$connect) {
    $error = 'Невозможно подключиться к базе данных: ' . mysqli_connect_error();
    $page_content = include_template('error.php', [
        'error' => $error
    ]);
} else {
    $page_content = include_template('register.php', []);
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form_register = $_POST;
    $errors = [];

    //Проверяем поле email на ошибки

    if (check_required($form_register['email'])) {
        $errors['email'] = 'Это поле надо заполнить';
    }

    //Проверяем поле password на ошибки

    if (check_required($form_register['password'])) {
        $errors['password'] = 'Это поле надо заполнить';
    }

    //Проверяем поле name на ошибки

    if (check_required($form_register['name'])) {
        $errors['name'] = 'Это поле надо заполнить';
    }


    if (count($errors) > 0) {
        $page_content = include_template('register.php', ['errors' => $errors]);
    } else {
        $sql = 'INSERT INTO users ( signed_up, email, name, password) VALUES (now(), ?, ?, ?)';
        $result = db_insert_data($connect, $sql, [
            $form_register['email'],
            $form_register['password'],
            $form_register['name']
        ]);
    }

    if ($result) {
        header('Location: /user_id=' . $result);
    }
}

    $layout_content = include_template('layout_non_auth.php', [
    'page_content' => $page_content,
    'title' => 'Форма регистрации',
]);

print_r($errors);

print($layout_content);