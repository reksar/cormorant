<?php namespace sanitize;

require_once 'err.php';
use sanitize;

require_once CORMORANT_DIR . 'core/contact/tag/confirmed.php';
use const \contact\tag\confirmed\SETTING_NAME;

function confirmed_tag($value)
{
    $tag_name = \contact\tag\confirmed\sanitize_name($value);

    if (! $tag_name)
        err(SETTING_NAME, __('Revert Cormorant -> Confirmed tag'));

    return $tag_name;
}
