<?php namespace settings;
/**
 * See `scheme.php` if you need to add or edit the Cormorant WP settings.
 *
 * Here are the functions to register and put all the parts of the settings
 * together to make them work.
 */

require_once 'scheme.php';
require_once 'sanitize.php';

define('settings\ALL_FIELDS',
    ...array_merge(array_map('\settings\section_fields', SECTIONS)));

use settings;

// These values may be overridden by field's `options['default']`.
// See `default_value()` below.
//
// Default value of a settings field.
const DEFAULT_VALUE = '';
// Override the `DEFAULT_VALUE` for a fields with specified `input_type`.
const TYPE_DEFAULTS = [
    'checkbox' => false,
    'number' => 0,
    'page_select' => 0,
];

function init()
{
    add_action('admin_init', '\settings\register');
    add_action('admin_menu', '\settings\add_page');
    add_action('update_option_' . NAME, '\settings\update', 10, 2);
}

function register()
{
    register_setting(GROUP, NAME, [
        'sanitize_callback' => 'settings\sanitize_all',
    ]);

    foreach (SECTIONS as $section) {
        add_settings_section(...args($section));

        foreach ($section['fields'] as $field)
            add_settings_field(...args($field, $section));
    }
}

function add_page()
{
    add_options_page(
        PAGE_TITLE,
        MENU_TITLE,
        'manage_options',
        PAGE_SLUG,
        'view\settings');
}

function update($old_settings, $new_settings)
{
    \settings\confirmed_tag\update($old_settings, $new_settings);
}

/**
 * @return value of the given setting name.
 */
function get($field_name)
{
    $settings = get_option(NAME);
    $sanitize = "sanitize\\$field_name";
    return $sanitize(@$settings[$field_name]) ?: default_value($field_name);
}

function default_value($field_name)
{
    $field = field($field_name);
    $type = $field['input_type'];
    $default = @$field['options']['default'];
    return $default ?? @TYPE_DEFAULTS[$type] ?? DEFAULT_VALUE;
}

/**
 * @return params of the setting field with the given `name`.
 * @see `scheme.php`.
 */
function field($name)
{
    foreach (ALL_FIELDS as $field)
        if (field_name($field) == $name)
            return $field;
}

function field_name($field)
{
    return $field['name'];
}

function section_fields($section)
{
    return $section['fields'];
}

/**
 * Turns the config dictionaries into the list of positional args.
 */
function args($config, $extra=[])
{
    extract($config);
    return [$name, $title, "view\\$name", PAGE_SLUG, @$extra['name']];
}
