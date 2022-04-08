<?php namespace action\admin_notify_email;
/**
 * This is an action module. The `init()` function is required for an action
 * to bind the action's features with the WP `add_action()`.
 */

use const \actions\ON_CONFIRM as ON_CONFIRM;

require_once CORMORANT_DIR . 'core/contact/admin-notify-email.php';

function init()
{
    if (\settings\get('notify_admin_on_confirmation'))
        add_action(ON_CONFIRM, '\contact\admin_notify_email\send');
}
