<?php namespace view;

require_once dirname(__DIR__) . '/input/input.php';

function notify_email_template()
{
    printf(
        '<p>%s %s</p><p>%s: <b>[email]</b></p>',
        __('Admin notify email template.'),
        __('HTML format is available.'),
        __('Sortcodes'));

    print(input(__FUNCTION__));
}
