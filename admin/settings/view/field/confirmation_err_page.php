<?php namespace view;

require_once dirname(__DIR__) . '/input/input.php';

function confirmation_err_page()
{
    printf(
        '<p>%s</p>',
        __('User will be redirected to this page when the contact with given 
            e-mail is not found in Flamingo records. Probably, contact has 
            been outdated. Home page used by default.'));

    input('page_select', __FUNCTION__);
}
