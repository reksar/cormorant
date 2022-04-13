<?php namespace view;

require_once dirname(__DIR__) . '/input/input.php';

function confirmed_tag()
{
    printf('<p>%s.</p>',
        __('This tag will be added to Flamingo contact when user confirms it'));

    printf('<p>%s <b>%s</b> (%s).</p>',
        __('Use'),
        __('alpabet, digits, dash'),
        __('no spaces'));

    print(input(__FUNCTION__));
}
