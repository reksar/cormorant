<?php namespace action\clear_expired_contacts;
/**
 * This is an action module. The `init()` function is required for an action
 * to bind the action's features with the WP `add_action()`.
 */

require_once CORMORANT_DIR . 'core/contact/contact.php';

function init()
{
    add_action(\actions\ON_CRON_DAILY, '\action\clear_expired_contacts\run');
}

function run()
{
    $days_to_confirm = \settings\get('days_to_confirm');

    if (! $days_to_confirm)
        return;

    $expired_contacts = \contact\find_unconfirmed_in($days_to_confirm);

    foreach ($expired_contacts as $contact) {
        delete_related_messages($contact);
        $contact->delete();
    }
}

function delete_related_messages($contact)
{
    foreach ($contact->related_messages() as $message)
        $message->delete();
}
