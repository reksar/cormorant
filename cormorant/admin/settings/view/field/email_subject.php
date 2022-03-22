<?php namespace view;

require_once dirname(__DIR__) . '/input/input.php';

function email_subject()
{
    print(input('text', __FUNCTION__));
}
