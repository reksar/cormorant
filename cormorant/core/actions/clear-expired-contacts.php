<?php namespace action\clear_expired_contacts;

require_once CORMORANT_DIR . 'core/contact/contact.php';

const ON_CRON_DAILY = 'flamingo_daily_cron_job';

function init()
{
    add_action(ON_CRON_DAILY, '\action\clear_expired_contacts\run');
}

function run()
{
    $days_to_confirm = \settings\get('days_to_confirm');

    if (! $days_to_confirm)
        return;

    $expired_contacts = \contact\find_unconfirmed_in($days_to_confirm);

    foreach ($expired_contacts as $contact) {
        $contact->delete_related_messages();
        $contact->delete();
    }
}
