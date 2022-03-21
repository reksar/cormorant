<?php namespace actions;
/**
 * All PHP files in this dir, except the current file, are considered action
 * modules. Here we automatically include all actions and call the `init()`
 * function for each of them.
 */
// TODO: automatize.

require_once 'ask-confirmation.php';
require_once 'get-confirmation.php';
require_once 'clear-expired-contacts.php';

function init()
{
    \action\ask_confirmation\init();
    \action\get_confirmation\init();
    \action\clear_expired_contacts\init();
}
