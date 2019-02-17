<?php

//подключение к БД
$connect = mysqli_connect("localhost", "mysql", "mysql", "doingsdone");
mysqli_set_charset($connect, "utf8");

//вывод таблиц из БД в массивы

$sql = "SELECT * FROM users";
$result = mysqli_query($connect, $sql);
mysqli_options($connect, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql = "SELECT * FROM projects";
$result = mysqli_query($connect, $sql);
mysqli_options($connect, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
$projects = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql = "SELECT * FROM tasks";
$result = mysqli_query($connect, $sql);
mysqli_options($connect, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
$tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);

/*
//вывод данных по пользователю с id = 4
$sql = "SELECT * FROM users WHERE id = '4'";
$users = db_fetch_data($connect, $sql);

$sql = "SELECT * FROM projects WHERE user_id = '4'";
$projects = db_fetch_data($connect, $sql);

$sql = "SELECT * FROM tasks WHERE user_id = '4'";
$tasks = db_fetch_data($connect, $sql);
*/

