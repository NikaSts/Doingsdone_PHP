<?php

// создание массива для проектов
$projects = ["Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];

// создание массива для задач
$tasks = [
    0 => [
        'task' => 'Собеседование в IT компании',
        'date' => '01.12.2019',
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
        'date' => NULL,
        'project' => $projects[3],
        'is_done' => false
    ],
    5 => [
        'task' => 'Заказать пиццу',
        'date' => NULL,
        'project' => $projects[3],
        'is_done' => false
    ]
];
