<?php namespace settings;

require_once 'scheme.php';
require_once 'class-sanitizer.php';
use settings;

function init()
{
    add_action('admin_init', 'settings\add');
    add_action('admin_menu', 'settings\show');
}

function add()
{
    register_setting(GROUP, NAME, [
        'sanitize_callback' => new settings\Sanitizer(),
    ]);

    foreach (SECTIONS as $section) {
        add_settings_section(...args($section));

        foreach ($section['fields'] as $field)
            add_settings_field(...args($field, $section));
    }
}

function show()
{
    add_options_page(
        PAGE_TITLE,
        MENU_TITLE,
        'manage_options',
        PAGE_SLUG,
        'view\settings');
}

/*
 * Turns the `config` dict into the list of positional args.
 */
function args($config, $extra=[])
{
    extract($config);
    return [$name, $title, "view\\$name", PAGE_SLUG, @$extra['name']];
}
