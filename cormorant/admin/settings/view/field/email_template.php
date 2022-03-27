<?php namespace view;

require_once dirname(__DIR__) . '/input/input.php';

function email_template()
{
    printf(
        '<p>%s %s</p><p>%s</p>',
        __('Confirmation email template.'),
        __('HTML format is available.'),
        __('Use <b>[confirmation-link]</b> shortcode.'));

    print(input(__FUNCTION__));
}
