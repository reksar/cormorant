<?php namespace flamingo;

const PLUGIN = 'flamingo/flamingo.php';

function is_ok()
{
    return in_array(PLUGIN, get_option('active_plugins'));
}
