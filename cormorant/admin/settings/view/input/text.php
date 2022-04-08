<?php namespace view\input;

require_once 'html.php';

function text($setting_name, $setting_value)
{
    $name = \view\html\setting_name($setting_name);

    return "<input type=\"text\" class=\"regular-text\" 
        id=\"$setting_name\" name=\"$name\" value=\"$setting_value\">";
}
