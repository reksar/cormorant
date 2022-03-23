<?php namespace view;

require_once dirname(__DIR__) . '/input/input.php';

function notify_admin_on_confirmation()
{
    print(input(__FUNCTION__));
}
