<?php namespace actions;
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
