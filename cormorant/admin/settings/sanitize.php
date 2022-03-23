<?php namespace settings;

function sanitize_all($settings)
{
    // TODO: sanitize checkboxes
    $keys = array_keys($settings);
    $values = array_map('settings\sanitize', $keys, $settings);
    return array_combine($keys, $values);
}

function sanitize($name, $value)
{
    $sanitizer = "sanitize\\$name";
    return $sanitizer($value);
}
