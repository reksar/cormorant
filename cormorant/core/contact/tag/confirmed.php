<?php namespace contact\tag\confirmed;

require_once CORMORANT_DIR . 'core/flamingo.php';
use const \flamingo\TAG_TAXONOMY;

const SETTING_NAME = 'confirmed_tag';
const DEFAULT_NAME = 'confirmed';
const SLUG = 'cormorant-confirmed';

function create()
{
    if (! exists())
        wp_insert_term(DEFAULT_NAME, TAG_TAXONOMY, [
            'slug' => SLUG,
        ]);
}

function exists()
{
    // The WP `term_exists()` is not suitable.
    return (bool) get_term_by('slug', SLUG, TAG_TAXONOMY);
}

function sanitize_name($name)
{
    return sanitize_text_field($name);
}

// TODO: see TODO in update hook. Maybe this is not needed.
function is_valid_name($name)
{
    return (bool) sanitize_name($name);
}

function set_name($name)
{
    $term = get_term_by('slug', SLUG, TAG_TAXONOMY);
    wp_update_term($term->term_id, TAG_TAXONOMY, [
        'name' => $name,
    ]);
}
