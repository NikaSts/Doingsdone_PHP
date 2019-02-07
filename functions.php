<?
// создание функции-шаблонизатора
function include_template($template, $data) {
    $template = 'templates/' . $template;
    $page_content = '';

if (!is_readable($template)) {
return $page_content;
}

ob_start();
extract($data);
require $template;

$page_content = ob_get_clean();

return $page_content;
}

// создание функции для подсчета задач у каждого из проектов
function calculate_amount($tasks, $project)
{
    $amount = 0;
    foreach ($tasks as $value) {
        if (isset($value['project'])) {
            continue;
        }
        if ($value['project'] === $project) {
            $amount++;
        }
    }
    return $amount;
}

?>
