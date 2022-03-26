<?php namespace view;
// TODO: JS - activate the feedback email template.

require_once dirname(__DIR__) . '/input/input.php';

function notify_admin_on_confirmation()
{
    print(input(__FUNCTION__));
}
