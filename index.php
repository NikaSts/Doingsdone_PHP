<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

include(__DIR__ . '/functions.php');

// создание массива для проектов
$projects = ["Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];

// создание массива для задач
$tasks = [
    0 => [
        'task' => 'Собеседование в IT компании',
        'date' => '09.02.2019',
        'project' => $projects[2],
        'is_done' => false
    ],
    1 => [
        'task' => 'Выполнить тестовое задание',
        'date' => '25.12.2019',
        'project' => $projects[2],
        'is_done' => false
    ],
    2 => [
        'task' => 'Сделать задание первого раздела',
        'date' => '21.12.2019',
        'project' => $projects[1],
        'is_done' => true
    ],
    3 => [
        'task' => 'Встреча с другом',
        'date' => '22.12.2019',
        'project' => $projects[0],
        'is_done' => false
    ],
    4 => [
        'task' => 'Купить корм для кота',
        'date' => '',
        'project' => $projects[3],
        'is_done' => false
    ],
    5 => [
        'task' => 'Заказать пиццу',
        'date' => '',
        'project' => $projects[3],
        'is_done' => false
    ]
];

$page_content = include_template('index.php', [
    'show_complete_tasks' => $show_complete_tasks,
    'tasks' => $tasks
]);

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'projects' => $projects,
    'tasks' => $tasks,
    'title' => 'Дела в порядке'
]);
print($layout_content);


