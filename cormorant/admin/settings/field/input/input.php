<?php namespace view;

// Templates of HTML inputs for a field views.
require_once 'checkbox.php';
require_once 'number.php';
require_once 'page_select.php';
require_once 'text.php';
require_once 'textarea.php';

/**
 * HTML input based on a settings field params described in the `scheme.php`.
 * Usually used as `print(input(__FUNCTION__))` in a field view.
 *
 * @param view_name - field view (function) name like `\view\<field_name>`.
 *
 * @return HTML (string) of a field input.
 */
function input($view_name)
{
    $field_name = name($view_name);
    $field_value = \settings\get($field_name);

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
