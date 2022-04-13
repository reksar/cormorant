<?php namespace settings\confirmed_tag;

require_once CORMORANT_DIR . 'core/flamingo.php';
use const \flamingo\TAG_TAXONOMY;

const TAG = 'confirmed_tag';

function update(array $old_settings, array $new_settings)
{
    $old_value = $old_settings[TAG];
    $new_value = $new_settings[TAG];

    if ($old_value == $new_value)
        return;

    if (is_invalid($new_value)) {
        replace($new_settings, $old_value);
        return;
    }

    update_tag_name($old_value, $new_value);
}

function is_invalid($value)
{
    return ! \sanitize\confirmed_tag($value);
}

function replace($settings, $value)
{
    update_option(\settings\NAME, array_replace($settings, [
        TAG => $value,
    ]));
}

function update_tag_name($old_value, $new_value)
{
    $term = get_term_by('name', $old_value, TAG_TAXONOMY)
        ?: get_term_by('slug', \settings\default_value(TAG), TAG_TAXONOMY);

    wp_update_term($term->term_id, TAG_TAXONOMY, [
        'name' => $new_value,
    ]);
}
