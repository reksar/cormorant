<?php namespace flamingo;
/*
 * Adapter for the original Flamingo plugin.
 */

require_once WP_PLUGIN_DIR . '/flamingo/includes/class-contact.php';
require_once WP_PLUGIN_DIR . '/flamingo/includes/class-inbound-message.php';
require_once CORMORANT_DIR . 'core/err/class-no-contact.php';

const PLUGIN = 'flamingo/flamingo.php';
const TAG_TAXONOMY = \Flamingo_Contact::contact_tag_taxonomy;

function is_active()
{
    return in_array(PLUGIN, get_option('active_plugins'));
}

function init()
{
    // TODO: check if already registered.
    \Flamingo_Contact::register_post_type();
}

function contact($email)
{
    // The `Flamingo_Contact::search_by_email()` returns one of existing
    // contact when we searching with the empty email, so we need to check
    // this first.
    if (! $email)
        throw new \err\No_Contact($email);

    $contact = \Flamingo_Contact::search_by_email($email);

    if (! $contact)
        throw new \err\No_Contact($email);

    return $contact;
}

function find_contacts($query_options)
{
    return \Flamingo_Contact::find($query_options);
}

function find_messages($email)
{
    return \Flamingo_Inbound_Message::find([
        'posts_per_page' => -1,
        'meta_key' => '_from_email',
        'meta_value' => $email,
    ]);
}

function add_tag($tag_name, $contact_id)
{
    wp_set_object_terms($contact_id, $tag_name, TAG_TAXONOMY, TRUE);
}

function tags($contact_id)
{
    $tags = wp_get_object_terms($contact_id, TAG_TAXONOMY);

    return array_map(

        function($tag) {
            return $tag->name;
        },

        $tags);
}
