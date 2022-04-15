<?php namespace action\admin_notify_email;

require_once 'interface.php';
use const \actions\ON_CONFIRM;

require_once CORMORANT_DIR . 'core/email/email.php';

const RUN = __NAMESPACE__ . '\run';

/**
 * Send notification email to admin when an user confirms email.
 */
function init()
{
    if (\settings\get('notify_admin_on_confirmation'))
        add_action(ON_CONFIRM, RUN);
}

function run($contact)
{
    $messages = $contact->related_messages();
    $last_message = (array) end($messages);
    \email\admin_notify($last_message);
}
