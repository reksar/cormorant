<?php namespace shortcodes;

const PAIR = __NAMESPACE__ . '\pair';
const REPLACE_PAIR = __NAMESPACE__ . '\replace_pair';

function map_keys($callback, $dict)
{
    $keys = array_keys($dict);
    $new_keys = array_map($callback, $keys);
    return array_combine($new_keys, $dict);
}

function replace($shortcodes, $template)
{
    $pairs = dict_to_pairs($shortcodes);
    return array_reduce($pairs, REPLACE_PAIR, $template);
}

function replace_pair($template, $pair)
{
    list($shortcode, $value) = $pair;
    return str_replace($shortcode, $value, $template);
}

function dict_to_pairs($dict)
{
    return array_map(PAIR, array_keys($dict), $dict);
}

function pair($x, $y)
{
    return [$x, $y];
}

function shortcode($key)
{
    return "[$key]";
}

function meta_shortcode($key)
{
    return "[_$key]";
}
