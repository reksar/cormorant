<?php namespace action\admin_notify_email;

require_once 'interface.php';
use const \actions\ON_CONFIRM;

require_once CORMORANT_DIR . 'core/contact/email/email.php';

/**
 * Send notification email to admin when an user confirms email.
 */
function init()
{
    if (\settings\get('notify_admin_on_confirmation'))
        add_action(ON_CONFIRM, '\email\admin_notify');
}
