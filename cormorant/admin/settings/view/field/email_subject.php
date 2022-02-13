<?php namespace view;

require_once dirname(__DIR__) . '/input/input.php';

function email_subject()
{
    input('text', __FUNCTION__);
}
