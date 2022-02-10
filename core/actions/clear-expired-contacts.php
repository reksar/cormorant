<?php namespace action\clear_expired_contacts;

require_once CORMORANT_DIR . 'core/flamingo.php';
require_once CORMORANT_DIR . 'core/contact/class-contact.php';

const DAYS_TO_CONFIRM = 1; // TODO: setting
const ON_CRON_DAILY = 'flamingo_daily_cron_job';

function init()
{
    add_action(ON_CRON_DAILY, '\action\clear_expired_contacts\run');
}

function run()
{
    $days_to_confirm = DAYS_TO_CONFIRM;

    // FIXME: unreachable
    if (! $days_to_confirm)
        return;

    // TODO: optimize WP_Query
    // TODO: wrap with `Contact`
    $all_contacts = \flamingo\find_contacts([
        'posts_per_page' => -1,
        'orderby' => 'date',
    ]);
    $unconfirmed_contacts = array_filter($all_contacts,
        '\action\clear_expired_contacts\is_unconfirmed');
    $expired_contacts = array_filter($unconfirmed_contacts,
        '\action\clear_expired_contacts\is_expired');
    array_walk($expired_contacts,
        '\action\clear_expired_contacts\delete_contact');
}

function delete_contact($contact)
{
    delete_related_messages($contact);
    $contact->delete();
}

// TODO: wrap with `Contact`
// FIXME: Contact tags are empty, so all contacts are considered as unconfirmed.
function is_unconfirmed($contact)
{
    return ! in_array(\Contact::TAG_CONFIRMED, $contact->tags);
}

// FIXME: last_contacted - is a bad idea.
function is_expired($contact)
{
    $current_date = new \DateTime();
    $contact_date = new \DateTime($contact->last_contacted);
    $contact_age = date_diff($current_date, $contact_date)->days;
    return DAYS_TO_CONFIRM < $contact_age;
}

// TODO: message wrapper
function delete_related_messages($contact)
{
    foreach (\flamingo\find_messages($contact->email) as $message)
        $message->delete();
}
