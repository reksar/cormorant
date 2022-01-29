<?php namespace view\html;

/*
 * @return 'settings_name[field_name]' for use in HTML attributes.
 */
function setting_name($field_name)
{
    return \settings\NAME . "[$field_name]";
}
