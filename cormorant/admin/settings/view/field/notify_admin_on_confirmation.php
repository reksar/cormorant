<?php namespace view;

require_once dirname(__DIR__) . '/input/input.php';

function notify_admin_on_confirmation()
{
    wp_enqueue_script(
        'cormorant-notify-admin-on-confirmation-js',
        plugin_dir_url(__FILE__) . 'js/notify_admin_on_confirmation.js',
        [],
        false,
        true);

    print(input(__FUNCTION__));
}
