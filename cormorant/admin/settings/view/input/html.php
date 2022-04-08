<?php namespace view\html;

/**
 * @return 'settings_name[field_name]' to use as the `name` attribute of a
 *   HTML input.
 */
function setting_name($field_name)
{
    return \settings\NAME . "[$field_name]";
}
