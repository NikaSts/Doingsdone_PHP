<?php
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);
// создание массива для проектов
$projects = ["Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];
// создание массива для задач
$tasks = [
    0 => [
        'task' => 'Собеседование в IT компании',
        'date' => '01.12.2019',
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

// создание функции для подсчета задач у каждого из проектов
function calculate_amount($tasks, $project)
{
    $amount = 0;
    foreach ($tasks as $value) {
        if (!isset($value['project'])) {
            if ($value['project'] === $project) {
                $amount++;
            }
        }
    }
    return $amount;
}

$page_name = '';
$page_content = '';

include(__DIR__ . '/templates/layout.php');

include(__DIR__ . '/functions.php');

?>