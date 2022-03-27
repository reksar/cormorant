<?php namespace view;

// Templates of the HTML inputs for field views.
require_once 'checkbox.php';
require_once 'number.php';
require_once 'page_select.php';
require_once 'text.php';
require_once 'textarea.php';

/**
 * Returns a HTML input for a settings field based on feild settings
 * described in the `scheme.php`.
 *
 * @param raw_field_name (string) - the name of a settings field or a view
 *   function name for this field. Usually used `print(input(__FUNCTION__))`
 *   inside a field view.
 *
 * @return HTML (string) of a field input.
 */
function input($raw_field_name)
{
    $field_name = name($raw_field_name);
    $field_value = value($field_name);

    $field_params = \settings\field($field_name);
    $input_type = $field_params['input_type'];
    $options = @$field_params['options'];

    $template = "\\view\\input\\$input_type";
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
