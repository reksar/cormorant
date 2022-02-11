<?php namespace action\clear_expired_contacts;

require_once CORMORANT_DIR . 'core/flamingo.php';
require_once CORMORANT_DIR . 'core/contact/class-contact.php';

const ON_CRON_DAILY = 'flamingo_daily_cron_job';

function init()
{
    add_action(ON_CRON_DAILY, '\action\clear_expired_contacts\run');
}

function run()
{
    $settings = get_option('cormorant_settings');
    $days_to_confirm = $settings['days_to_confirm'];

    if (! $days_to_confirm)
        return;

    // TODO: wrap with `Contact`
    $expired_contacts = \flamingo\find_contacts([
        'posts_per_page' => -1,
        'date_query' => [[
            'before' => "$days_to_confirm days ago",
        ]],
        'tax_query' => [[
            // Exclude all that has the `confirmed` tag, i.e.
            // exclude objects, ...
            'operator' => 'NOT IN',
            // with the taxonomy ...
            'taxonomy' => \flamingo\TAG_TAXONOMY,
            // and the field ...
            'field' => 'name',
            // that equals to
            'terms' => \Contact::TAG_CONFIRMED,
        ]],
    ]);

    array_walk($expired_contacts,
        '\action\clear_expired_contacts\delete_contact');
}

function delete_contact($contact)
{
    delete_related_messages($contact);
    $contact->delete();
}

// TODO: message wrapper
function delete_related_messages($contact)
{
    foreach (\flamingo\find_messages($contact->email) as $message)
        $message->delete();
}
