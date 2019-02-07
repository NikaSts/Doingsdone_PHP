<?
// функция-шаблонизатор
function include_template($name, $data)
{
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
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


