<?php namespace shortcodes;

require_once 'utils.php';
use shortcodes;

// Fields of a `Flamingo_Inbound_Message` object.
// Note: here we axpect a message as `array` not an `object`.
const BASIC_KEYS = [
    'from_email',
    'from_name',
    'subject',
];

// Keys of array `Flamingo_Inbound_Message Object::meta`.
const META_KEYS = [
    'date',
    'time',
    'remote_ip',
];

function common($message)
{
    return array_merge(basic($message), meta($message), fields($message));
}

function basic($message)
{
    $dict = array_intersect_key($message, array_flip(BASIC_KEYS));
    return map_keys(__NAMESPACE__ . '\shortcode', $dict);
}

function meta($message)
{
    $dict = array_intersect_key($message['meta'], array_flip(META_KEYS));
    return map_keys(__NAMESPACE__ . '\meta_shortcode', $dict);
}

function fields($message)
{
    $dict = array_filter($message['fields'], 'is_scalar');
    return map_keys(__NAMESPACE__ . '\shortcode', $dict);
}
