<?php
session_start();

require_once 'vendor/autoload.php';
require_once 'functions.php';
require_once 'config/db.php';

$connect = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($connect, "utf8");
mysqli_options($connect, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);

$user_id = 0;
$is_auth = 0;
if (isset($_SESSION['id'])) {
    $user_id = intval($_SESSION['id']);
    $is_auth = 1;
}
