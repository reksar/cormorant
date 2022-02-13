<?php namespace view\input;

require_once 'html.php';

function text($setting_name, $setting_value)
{
    $name = \view\html\setting_name($setting_name);

    $template = "<input type=\"text\" class=\"regular-text\" 
        id=\"$setting_name\" name=\"$name\" value=\"%s\">";

    // Replace `%s` with `setting_value`.
    printf($template, $setting_value);
}
