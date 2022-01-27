<?php namespace view\input;

require_once 'html.php';

function page_select(string $field_name, string $field_value)
{
    $name = \view\html\setting_name($field_name);

    print(wp_dropdown_pages([
        'name'              => $name,
        'echo'              => 0,
        'show_option_none'  => __('&mdash; Select &mdash;'),
        'option_none_value' => '0',
        'selected'          => $field_value,
    ]));
}
