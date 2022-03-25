<?php namespace view;
// TODO: JS - set the `value` to 1 if `checked`.
// TODO: JS - change the `checked` attr respectively to the `value`.
// TODO: JS - activate the feedback email template.

require_once dirname(__DIR__) . '/input/input.php';

function notify_admin_on_confirmation()
{
    print(input(__FUNCTION__));
}
