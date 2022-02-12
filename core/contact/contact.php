<?php namespace contact;
/*
 * Entry point to interact with high-level contacts features.
 * Interlayer between the Cormorant actions and the Flamingo facade.
 */

require_once CORMORANT_DIR . 'core/flamingo.php';

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
            'field' => 'name',
            // that equals to
            'terms' => \Contact::TAG_CONFIRMED,
        ]],
    ]);

    return array_map('\contact\wrap', $expired_contacts);
}

function wrap($flamingo_contact)
{
    return new \Contact($flamingo_contact);
}
