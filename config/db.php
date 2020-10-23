<?php
$url = getenv('JAWSDB_URL');
$dbparts = parse_url($url);

$db = [
    'host' => $dbparts['host'],
    'user' => $dbparts['user'],
    'password' => $dbparts['pass'],
    'database' => ltrim($dbparts['path'],'/')
];
