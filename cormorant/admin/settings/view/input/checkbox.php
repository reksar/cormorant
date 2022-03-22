<?php namespace view\input;

require_once 'html.php';

/**
 * @param options = [
 *   'label' => <string>,
 * ]
 */
function checkbox($setting_name, $setting_value, $options=[])
{
    $label = $options['label'] ?? '';

    $name = \view\html\setting_name($setting_name);

    return "<label for=\"$setting_name\">
        <input type=\"checkbox\" id=\"$setting_name\" name=\"$name\"
        value=\"$setting_value\">$label</label>";
}
