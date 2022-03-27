<?php namespace view;

require_once dirname(__DIR__) . '/input/input.php';

function notify_email_template()
{
    printf(
        '<p>%s %s</p>',
        __('Admin notify email template.'),
        __('HTML format is available.'));

    print(input(__FUNCTION__));
}
