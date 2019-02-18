<?php

require_once 'mysql_helper.php';

// создание функции-шаблонизатора
function include_template($name, $data)
{
    $name = 'templates/' . $name;
    $page_content = '';

    if (!is_readable($name)) {
        return $page_content;
    }

    ob_start();
    extract($data);
    require $name;

    $page_content = ob_get_clean();

    return $page_content;
}

// создание функции для подсчета задач у каждого из проектов
function calculate_amount($tasks, $project)
{
    $amount = 0;
    foreach ($tasks as $value) {
        if (!isset($value['project_id'])) {
            continue;
        }
        if ($value['project_id'] === $project) {
            $amount++;
        }
    }
    return $amount;
}

//функция расчета времени до запланированного задания
function time_counter($date)
{
    if ($date === NULL) {
        return false;
    }
    $time_left = floor((strtotime($date) - time()) / 3600);
    if ($time_left <= 24) {
        return true;
    } else {
        return false;
    }
}

//функция для чтения записей из БД
function db_fetch_data($connect, $sql, $data = [])
{
    $result = [];
    $stmt = db_get_prepare_stmt($connect, $sql, $data);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    return $result;
}

//Функция для добавления записей в БД
function db_insert_data($connect, $sql, $data = []) {
    $stmt = db_get_prepare_stmt($connect, $sql, $data);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $result = mysqli_insert_id($connect);
    }
    return $result;
}


