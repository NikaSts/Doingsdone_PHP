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

