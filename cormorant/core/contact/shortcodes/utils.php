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

/**
 * Some values may be non scalar, i.e. arrays.
 *
 * @return dict of scalar values.
 */
function scalarize($dict)
{
    $scalar = array_filter($dict, 'is_scalar');
    $selects = scalar_selects($dict);
    return array_merge($scalar, $selects);
}

/**
 * Selects from submitted HTML form are represented as array[1], i.e
 * [
 *   <...>,
 *
 *   <select name> => [ <value> ],
 *
 *   <...>,
 * ]
 *
 * @return dict of scalar selects, i.e.
 * [
 *   <select name> => <value>,
 * ]
 */
function scalar_selects($dict)
{
    $selects = array_filter($dict, '\shortcodes\is_select_value');
    $scalar_values = array_map('end', $selects);
    return array_combine(array_keys($selects), $scalar_values);
}

function is_select_value($value)
{
    return is_array($value)
        && count($value) == 1
        && array_key_exists(0, $value)
        && $value[0];
}
