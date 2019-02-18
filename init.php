<?php

require_once 'functions.php';

$db = require_once 'config/db.php';

//$connect = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
$connect = mysqli_connect("localhost", "mysql", "mysql", "doingsdone");
mysqli_set_charset($connect, "utf8");
mysqli_options($connect, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);


