<?php namespace view\input;

require_once 'html.php';

/**
 * @param options = [
 *   'label' => <string>,
 * ]
 */
function checkbox($setting_name, bool $setting_value, $options=[])
{
    $label = $options['label'] ?? '';

    $name = \view\html\setting_name($setting_name);

    $checked = $setting_value ? 'checked' : '';

    return "<label for=\"$setting_name\">
        <input type=\"checkbox\" id=\"$setting_name\" name=\"$name\"
        value=\"$setting_value\" $checked>$label</label>";
}
