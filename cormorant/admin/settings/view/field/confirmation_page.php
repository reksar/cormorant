<?php namespace view;

require_once dirname(__DIR__) . '/input/input.php';

function confirmation_page()
{
    printf(
        '<p>%s</p>',
        __('User will be redirected to this page after confirmation success. 
            Home page used by default.'));

    print(input(__FUNCTION__));
}
