<?php namespace settings;

require_once 'scheme.php';
require_once 'sanitize.php';
use settings;

require_once 'view/settings.php';

// Each section requires the file `view/section/{section_name}.php`
foreach (glob(__DIR__ . '/view/section/*.php') as $section_view)
    require_once $section_view;

// Each field requires the file `view/field/{field_name}.php`
foreach (glob(__DIR__ . '/view/field/*.php') as $field_view)
    require_once $field_view;
// and the file `sanitize/{field_name}.php`
foreach (glob(__DIR__ . '/sanitize/*.php') as $sanitizer)
    require_once $sanitizer;

function init()
{
    add_action('admin_init', '\settings\add');
    add_action('admin_menu', '\settings\show');
}

function add()
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
 * Turns the config dictionaries into the list of positional args.
 */
function args($config, $extra=[])
{
    extract($config);
    return [$name, $title, "view\\$name", PAGE_SLUG, @$extra['name']];
}
