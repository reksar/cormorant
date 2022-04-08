<?php namespace actions;
/**
 * All PHP files in this dir, except the current file and the `interface.php`,
 * are considered action modules. Here we automatically include all actions
 * and call the `init()` function for each of them.
 *
 * The `interface.php` contains a definitions shared between actions and other
 * third-party modules.
 */

require_once 'interface.php';

// TODO: automatize.

require_once 'ask-confirmation.php';
require_once 'get-confirmation.php';
require_once 'clear-expired-contacts.php';
require_once 'admin-notify-email.php';

function init()
{
    \action\ask_confirmation\init();
    \action\get_confirmation\init();
    \action\clear_expired_contacts\init();
    \action\admin_notify_email\init();
}
