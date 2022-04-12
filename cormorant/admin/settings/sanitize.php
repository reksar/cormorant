<?php namespace settings;

function sanitize($name, $value)
{
    $sanitizer = "sanitize\\$name";
    return $sanitizer($value);
}

function sanitize_all($raw_settings)
{
    $keys = array_keys($raw_settings);
    $settings = preprocess_checkboxes($keys, $raw_settings);
    $values = array_map('settings\sanitize', $keys, $settings);
    return array_combine($keys, $values);
}

/**
 * All checkboxes passed in the settings array are checked. But some of them
 * may have '' or 0 value that can be considered by sanitizer as not checked
 * (bool false) further. So here we avoiding that by replacing the valid
 * `CHECKEDBOX` value.
 *
 * This is the insurance for the case if the same JS feature is not working.
 */
function preprocess_checkboxes($keys, $settings)
{
    $checkbox_names = array_intersect(all_checkbox_names(), $keys);
    $checkboxes = array_fill_keys($checkbox_names, true);
    return array_replace($settings, $checkboxes);
}

function all_checkbox_names()
{
    $checkboxes = array_filter(ALL_FIELDS, '\settings\is_checkbox');
    return array_map('\settings\field_name', $checkboxes);
}

function is_checkbox($field)
{
    return $field['input_type'] == 'checkbox';
}
