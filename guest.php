<?php

require_once 'init.php';

session_start();
$is_auth = 0;
$page_content = include_template('guest.php', []);

$layout_content = include_template('layout.php', [
'page_content' => $page_content,
'title' => 'Сервис «Дела в порядке»',
]);

print($layout_content);


