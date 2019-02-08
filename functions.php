<?
// создание функции-шаблонизатора
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

// создание функции для подсчета задач у каждого из проектов
function calculate_amount($tasks, $project)
{
    $amount = 0;
    foreach ($tasks as $value) {
        if (!isset($value['project'])) {
            continue;
        }
        if ($value['project'] === $project) {
            $amount++;
        }
    }
    return $amount;
}

//функция расчета времени до запланированного задания

function time_counter($date)
{
    if ($date === '') {
        return false;
    }
    $time_left = floor((strtotime($date) - time()) / 3600);
    if ($time_left <= 24) {
        return true;
    } else {
        return false;
    }
}


