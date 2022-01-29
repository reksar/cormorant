<?php

require_once 'settings.php';
require_once 'class-sanitizer.php';
require_once 'view/settings.php';

foreach (glob(__DIR__ . '/view/section/*.php') as $section_view)
    require_once $section_view;

foreach (glob(__DIR__ . '/view/field/*.php') as $field_view)
    require_once $field_view;

class Settings
{
    public function __construct()
    {
        add_action('admin_init', 'Settings::init');
        add_action('admin_menu', 'Settings::show');
    }

    public static function init()
    {
        register_setting(settings\GROUP, settings\NAME, [
            'sanitize_callback' => new settings\Sanitizer(),
        ]);

        foreach (settings\SECTIONS as $section) {
            add_settings_section(...self::args($section));

            foreach ($section['fields'] as $field)
                add_settings_field(...self::args($field, $section));
        }
    }

    public static function show()
    {
        add_options_page(
            settings\PAGE_TITLE,
            settings\MENU_TITLE,
            'manage_options',
            settings\PAGE_SLUG,
            'view\settings');
    }

    /*
     * Turns the `config` dict into the list of positional args.
     */
    private static function args($config, $extra=[])
    {
        extract($config);
        return [
            $name,
            $title,
            "view\\$name",
            settings\PAGE_SLUG,
            @$extra['name'],
        ];
    }
}
