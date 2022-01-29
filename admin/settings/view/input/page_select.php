<?php namespace view\input;

require_once 'html.php';

function page_select($name, $value)
{
    print(wp_dropdown_pages([
        'name'              => \view\html\setting_name($name),
        'echo'              => 0,
        'show_option_none'  => __('&mdash; Select &mdash;'),
        'option_none_value' => '0',
        'selected'          => $value,
    ]));
}
