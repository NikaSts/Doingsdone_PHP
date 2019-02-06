<?
function include_template($template, $array) {
    $template = 'templates/' . $template;
    $page_content = '';

if (!is_readable($template)) {
return $page_content;
}

ob_start();
extract($array);
require $template;

$page_content = ob_get_clean();

return $page_content;
}


?>