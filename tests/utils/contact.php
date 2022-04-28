<?php namespace utils\contact;

const DATE_TIME_FORMAT = 'Y-m-d H:i:s'; // WP `mysql` type for time.

// The delay emulation before tests.
const EXTRA_TIME = '-1 hour';

function total(): int
{
    return \Flamingo_Contact::count([
        'posts_per_page' => -1,
    ]);
}

function add($email, $name, int $age_days=0, $tags=[])
{
    $contact = flamingo($email, $name);
    add_tags($contact, $tags);
    set_age_days($contact, $age_days);
}

function flamingo($email, $name)
{
    return \Flamingo_Contact::add([
        'email' => $email,
        'name' => $name,
    ]);
}

function add_tags($contact, array $tags)
{
    $contact->tags = array_merge($contact->tags, $tags);
    $contact->save();
}

function set_age_days($contact, int $days)
{
    $date = days_offset(-$days);

    wp_update_post([
        'ID' => $contact->id(),
        'post_date' => $date,
        'post_date_gmt' => get_gmt_from_date($date),
    ]);
}

function days_offset(int $days): string
{
    return (new \DateTime('now'))
        ->modify("$days days")
        ->modify(EXTRA_TIME)
        ->format(DATE_TIME_FORMAT);
}
