<?php namespace view\html;

/*
 * @return 'settings_name[field_name]'
 */
function setting_name($field_name)
{
    return \settings\NAME . "[$field_name]";
}
