<?php

require_once 'mysql_helper.php';

/**
 * Шаблонизатор
 * @param $name
 * @param $data
 * @return false|string
 */
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

/**
 * Определяет, истек ли срок выполнения задания
 * @param $date
 * @return bool
 */
function time_counter($date)
{
    if (!$date) {
        return false;
    }

    return time() - strtotime($date) >= 0 ? true : false;
}

/**
 * Читает записи из БД
 * @param $connect
 * @param $sql
 * @param array $data
 * @return array|null
 */
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

//Функция для
/**
 * Добавляет записи в БД
 * @param $connect
 * @param $sql
 * @param array $data
 * @return bool|int|string
 */
function db_insert_data($connect, $sql, $data = [])
{
    $stmt = db_get_prepare_stmt($connect, $sql, $data);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        $result = mysqli_insert_id($connect);
    }
    return $result;
}

/**
 * Фильтрирует данные, получаемые от пользователей
 * @param $str
 * @return string
 */
function esc($str)
{
    return htmlspecialchars($str);
}

/**
 * Проверяет, что переданная дата соответствует формату ДД.ММ.ГГГГ
 * @param string $date строка с датой
 * @return bool
 */
function check_date_format($date) {
    $result = false;
    $regexp = '/(\d{2})\.(\d{2})\.(\d{4})/m';
    if (preg_match($regexp, $date, $parts) && count($parts) == 4) {
        $result = checkdate($parts[2], $parts[1], $parts[3]);
    }
    return $result;
}

