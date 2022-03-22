<?php namespace view;

// Templates of the HTML inputs for field views.
require_once 'checkbox.php';
require_once 'number.php';
require_once 'page_select.php';
require_once 'text.php';
require_once 'textarea.php';

/**
 * Entry point for adding a HTML input into field views.
 *
 * @param input_type (string) - one of the templates:
 *   - checkbox
 *   - number
 *   - page_select
 *   - text
 *   - textarea
 *
 * @param view_function (string) - the name of the view function for a
 *   settings field. Use the `__FUNCTION__` magic const.
 *
 * @param options (array) - extra params for an input template.
 *
 * @return HTML (string) of a field input.
 */
function input($input_type, $view_function, $options=[])
{
    $template = "\\view\\input\\$input_type";
    $field_name = name($view_function);
    $field_value = value($field_name);
    return $template($field_name, $field_value, $options);
}

/**
 * @return 'view\\name' -> 'name'
 */
function name($namespaced)
{
    $name_chain = explode('\\', $namespaced);
    return end($name_chain);
}

function value($field_name)
{
    $settings = get_option(\settings\NAME);
    $field_value = $settings[$field_name] ?? '';
    return \settings\sanitize($field_name, $field_value);
}
