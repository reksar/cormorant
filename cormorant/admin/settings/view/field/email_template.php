<?php namespace view;

require_once dirname(__DIR__) . '/input/input.php';

function email_template()
{
    printf(
        '<p>%s</p>',
        __('Template for the confirmation letter (HTML format is available). 
            Use <b>[confirmation-link]</b> shortcode.'));

    print(input('textarea', __FUNCTION__));
}
