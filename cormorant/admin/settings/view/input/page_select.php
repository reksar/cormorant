<?php namespace view\input;

require_once 'html.php';

function page_select($setting_name, $setting_value)
{
    return wp_dropdown_pages([
        'name'              => \view\html\setting_name($setting_name),
        'echo'              => 0,
        'show_option_none'  => __('&mdash; Select &mdash;'),
        'option_none_value' => '0',
        'selected'          => $setting_value,
    ]);
}
