<?php namespace view;

require_once dirname(__DIR__) . '/input/input.php';

function days_to_confirm()
{
    // TODO: unite with sanitizer.
    $max_days = 365;

    printf(
        '<p>%s</p>',
        __('Flamingo contacts and related messages will be deleted if they ' .
            "are not confirmed within this time. Up to $max_days."));

    printf(
        '<p>%s</p>',
        __('Set to 0 if unconfirmed contacts cleanup is not needed.'));

    input('number', __FUNCTION__, [
        'min' => 0,
        'max' => $max_days,
    ]);
}
