<?php namespace view;

require_once 'page_select.php';

foreach (glob(dirname(__DIR__) . '/sanitize/*.php') as $sanitizer)
    require_once $sanitizer;

function value($field_name)
{
    $settings = get_option(\settings\NAME);
    $field_value = $settings[$field_name] ?? '';
    $sanitize = "\\sanitize\\$field_name";
    return $sanitize($field_value);
}

function input($input_type, $view_function)
{
    $field_name = basename($view_function);
    $field_value = value($field_name);
    $template = "\\view\\input\\$input_type";
    $template($field_name, $field_value);
}
