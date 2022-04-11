<?php namespace view;

require_once dirname(__DIR__) . '/input/input.php';
require_once dirname(__DIR__) . '/shortcodes.php';

function email_template()
{
    printf(
        '<p>%s. %s.</p><p>%s: <b>%s</b></p><p>%s: <b>%s</b></p><p>%s.</p>',
        __('Confirmation email template'),
        __('HTML format is available'),
        __('Default shortcodes'),
        default_shortcodes(),
        __('Confirmation link shortcode'),
        confirmation_link_shortcode(),
        __('Shortcodes for Contact Form 7 custom named fields are available'));

    print(input(__FUNCTION__));
}
