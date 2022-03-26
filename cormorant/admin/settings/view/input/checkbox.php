<?php namespace view\input;

require_once 'html.php';

/**
 * @param options = [
 *   'label' => <string>,
 * ]
 */
function checkbox($setting_name, bool $setting_value, $options=[])
{
    wp_enqueue_script('cormorant-checkbox-js',
        plugin_dir_url(__FILE__) . 'js/checkbox.js', [], false, true);

    $label = $options['label'] ?? '';

    $name = \view\html\setting_name($setting_name);

    $checked = $setting_value ? 'checked' : '';

    return "<label for=\"$setting_name\">
        <input type=\"checkbox\" id=\"$setting_name\" name=\"$name\"
        value=\"$setting_value\" $checked>$label</label>";
}
