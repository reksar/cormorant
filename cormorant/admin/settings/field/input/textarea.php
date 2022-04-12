<?php namespace view\input;

require_once 'html.php';

function textarea($setting_name, $setting_value)
{
    $name = \view\html\setting_name($setting_name);

    return "<textarea class=\"large-text code\" rows=\"10\"
        id=\"$setting_name\" name=\"$name\">$setting_value</textarea>";
}
