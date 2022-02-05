<?php namespace flamingo;

require_once WP_PLUGIN_DIR . '/flamingo/includes/class-contact.php';

const PLUGIN = 'flamingo/flamingo.php';
const TAG_TAXONOMY = \Flamingo_Contact::contact_tag_taxonomy;

function is_active()
{
    return in_array(PLUGIN, get_option('active_plugins'));
}

function add_tag($tag_name, $contact_id)
{
    wp_set_post_terms($contact_id, $tag_name, TAG_TAXONOMY, TRUE);
}

function tag_names($contact_id)
{
    $tags = wp_get_post_terms($contact_id, TAG_TAXONOMY);

    return array_map(

        function($tag) {
            return $tag->name;
        },

        $tags);
}
