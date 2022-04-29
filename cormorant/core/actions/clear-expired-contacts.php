<?php namespace action\clear_expired_contacts;

require_once 'interface.php';
use const \actions\ON_CRON_DAILY;

require_once CORMORANT_DIR . 'core/contact/contact.php';

const RUN = __NAMESPACE__ . '\run';
const CLEAR = __NAMESPACE__ . '\clear';

function init()
{
    add_action(ON_CRON_DAILY, RUN);
}

function run()
{
    $days_to_confirm = \settings\get('days_to_confirm');

    if (! $days_to_confirm)
        return;

    $expired_contacts = \contact\find_unconfirmed_in($days_to_confirm);
    array_walk($expired_contacts, CLEAR);
}

function clear($contact)
{
    foreach ($contact->related_messages() as $message)
        $message->delete();

    $contact->delete();
}
