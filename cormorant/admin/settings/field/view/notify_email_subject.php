<?php namespace view;

require_once dirname(__DIR__) . '/input/input.php';

function notify_email_subject()
{
    print(input(__FUNCTION__));
}
