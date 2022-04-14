<?php namespace settings\confirmed_tag;

require_once CORMORANT_DIR . 'core/contact/tag/confirmed.php';
use const \contact\tag\confirmed\SETTING_NAME;

function update(array $old_settings, array $new_settings)
{
    $old_value = $old_settings[SETTING_NAME];
    $new_value = $new_settings[SETTING_NAME];

    if ($old_value == $new_value)
        return;

    if (! $new_value) {
        replace($new_settings, $old_value);
        return;
    }

    \contact\tag\confirmed\set_name($new_value);
}

function replace($settings, $value)
{
    update_option(\settings\NAME, array_replace($settings, [
        SETTING_NAME => $value,
    ]));
}
