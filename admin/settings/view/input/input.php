<?php namespace view;

require_once 'page_select.php';
require_once 'text.php';
require_once 'textarea.php';

function value($field_name)
{
    $settings = get_option(\settings\NAME);
    $field_value = $settings[$field_name] ?? '';
    return \settings\sanitize($field_name, $field_value);
}

function input($input_type, $view_function)
{
    $field_name = basename($view_function);
    $field_value = value($field_name);
    $template = "\\view\\input\\$input_type";
    $template($field_name, $field_value);
}
