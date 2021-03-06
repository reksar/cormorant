<?php namespace contact;
/**
 * It is the interlayer between the Cormorant actions and the Flamingo facade.
 * The factory that wraps a Flamingo contacts with the `Contact` class.
 */

require_once 'class-contact.php';
require_once CORMORANT_DIR . 'core/flamingo.php';
require_once CORMORANT_DIR . 'core/err/class-bad-token.php';

require_once 'tag/confirmed.php';
use const \contact\tag\confirmed\SLUG as CONFIRMED_TAG_SLUG;

function wrap($flamingo_contact)
{
    return new \Contact($flamingo_contact);
}

function by_email($email)
{
    return wrap(\flamingo\contact($email));
}

function by_token($token)
{
    $email = \contact\token\email($token);
    $flamingo_contact = \flamingo\contact($email);

    // Flamingo looks for contacts by email and this is additional check that
    // found contact have valid ID.
    $id = \contact\token\id($token);
    if ($flamingo_contact->id() !== $id)
        throw new \err\Bad_Token($token);

    return wrap($flamingo_contact);
}

function find_unconfirmed_in($days)
{
    $expired_contacts = \flamingo\find_contacts([
        'posts_per_page' => -1,
        'date_query' => [[
            'before' => "$days days ago",
        ]],
        'tax_query' => [[
            // Exclude all that has the `confirmed` tag, i.e.
            // exclude objects, ...
            'operator' => 'NOT IN',
            // with the taxonomy ...
            'taxonomy' => \flamingo\TAG_TAXONOMY,
            // and the field ...
            'field' => 'slug',
            // that equals to
            'terms' => CONFIRMED_TAG_SLUG,
        ]],
    ]);

    return array_map('\contact\wrap', $expired_contacts);
}
