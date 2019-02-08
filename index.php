<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);
// создание массива для проектов
$projects = ["Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];
// создание массива для задач
$tasks = [
    0 => [
        'task' => 'Собеседование в IT компании',
        'date' => '09.12.2019',
        'project' => 'Работа',
        'is_done' => false
    ],
    1 => [
        'task' => 'Выполнить тестовое задание',
        'date' => '25.12.2019',
        'project' => 'Работа',
        'is_done' => false
    ],
    2 => [
        'task' => 'Сделать задание первого раздела',
        'date' => '21.12.2019',
        'project' => 'Учеба',
        'is_done' => true
    ],
    3 => [
        'task' => 'Встреча с другом',
        'date' => '22.12.2019',
        'project' => 'Входящие',
        'is_done' => false
    ],
    4 => [
        'task' => 'Купить корм для кота',
        'date' => '',
        'project' => 'Домашние дела',
        'is_done' => false
    ],
    5 => [
        'task' => 'Заказать пиццу',
        'date' => '',
        'project' => 'Домашние дела',
        'is_done' => false
    ]
];


include(__DIR__ . '/functions.php');


$page_content = include_template('index.php', [
    'show_complete_tasks' => $show_complete_tasks,
    'tasks' => $tasks
]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'projects' => $projects,
    'tasks' => $tasks,
    'page_name' => 'проект Дела в порядке'
]);
print($layout_content);

// вызов функции
$time_left  = time_counter ([
    'date' => $date
]);

