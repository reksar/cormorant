<?php namespace action\admin_notify_email;
/**
 * This is an action module. The `init()` function is required for an action
 * to bind the action's features with the WP `add_action()`.
 */

require_once CORMORANT_DIR . 'core/contact/email/admin-notify.php';

function init()
{
    if (\settings\get('notify_admin_on_confirmation'))
        add_action(\actions\ON_CONFIRM, '\email\admin_notify\send');
}
