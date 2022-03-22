<?php namespace view\input;

require_once 'html.php';

/**
 * @param options = [
 *   'min' => <int>,
 *   'max' => <int>,
 * ]
 */
function number($setting_name, $setting_value, $options=[])
{
    $min = isset($options['min']) ? (int) $options['min'] : '';
    $max = isset($options['max']) ? (int) $options['max'] : '';

    $name = \view\html\setting_name($setting_name);

    return "<input type=\"number\" class=\"regular-text\" id=\"$setting_name\"
        min=\"$min\" max=\"$max\" name=\"$name\" value=\"$setting_value\">";
}
