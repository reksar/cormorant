<?php namespace view;

require_once 'number.php';
require_once 'page_select.php';
require_once 'text.php';
require_once 'textarea.php';

function input($input_type, $view_function, $options=[])
{
    $field_name = name($view_function);
    $field_value = value($field_name);
    $template = "\\view\\input\\$input_type";
    $template($field_name, $field_value, $options);
}

function value($field_name)
{
    $settings = get_option(\settings\NAME);
    $field_value = $settings[$field_name] ?? '';
    return \settings\sanitize($field_name, $field_value);
}

/**
 * @return 'view\\name' -> 'name'
 */
function name($namespaced)
{
    // Does it exists an oneliner in PHP?
    $names = explode('\\', $namespaced);
    return end($names);
}
