<?php namespace settings;
/**
 * See `scheme.php` if you need to add or edit the Cormorant WP settings.
 *
 * Here are the functions to register and put all the parts of the settings
 * together to make them work.
 */

require_once 'scheme.php';
require_once 'sanitize.php';
use settings;

function init()
{
    add_action('admin_init', '\settings\register');
    add_action('admin_menu', '\settings\add_page');
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

/**
 * @return value of the given setting name.
 */
function get($field_name)
{
    $settings = get_option(NAME);
    $value = @$settings[$field_name] ?? default_value($field_name);
    $sanitize = "sanitize\\$field_name";
    return $sanitize($value);
}

function default_value($field_name)
{
    return field($field_name)['default'] ?? '';
}

function field($name)
{
    foreach (all_fields() as $field)
        if ($field['name'] == $name)
            return $field;
}

/**
 * @return fields of all settings section.
 */
function all_fields()
{
    return array_merge(...array_map('\settings\section_fields', SECTIONS));
}

function section_fields($section)
{
    return $section['fields'];
}

/*
 * Turns the config dictionaries into the list of positional args.
 */
function args($config, $extra=[])
{
    extract($config);
    return [$name, $title, "view\\$name", PAGE_SLUG, @$extra['name']];
}
