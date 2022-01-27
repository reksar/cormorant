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
                add_settings_field(...self::args_ext($field, $section));
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
     * Turns the `config` array into the array of positional args for the 
     * `add_settings_section()`.
     */
    private static function args($config)
    {
        return [
            $config['name'],
            $config['title'],
            'view\\' . $config['name'],
            settings\PAGE_SLUG,
        ];
    }

    /*
     * Turns the two arrays into the one array of positional args for the 
     * `add_settings_field()`, i.e. appends the extra name to `args()`.
     */
    private static function args_ext($config, $extra)
    {
        return [...self::args($config), $extra['name']];
    }
}
