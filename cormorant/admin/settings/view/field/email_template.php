<?php namespace view;

require_once dirname(__DIR__) . '/input/input.php';

function email_template()
{
    printf(
        '<p>%s %s</p><p>%s: <b>[confirmation-link]</b></p>',
        __('Confirmation email template.'),
        __('HTML format is available.'),
        __('Shortcodes'));

    print(input(__FUNCTION__));
}
