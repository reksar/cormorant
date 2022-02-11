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

    $template = "<input type=\"number\" class=\"regular-text\" min=\"$min\"
        max=\"$max\" id=\"$setting_name\" name=\"$name\" value=\"%s\">";

    // Replace `%s` with `setting_value`.
    printf($template, $setting_value);
}
