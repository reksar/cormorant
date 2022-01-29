<?php namespace settings;

require_once 'view/settings.php';

// Each section requires the file `view/section/{section_name}.php`
foreach (glob(__DIR__ . '/view/section/*.php') as $section_view)
    require_once $section_view;

// Each field requires the file `view/field/{field_name}.php`
foreach (glob(__DIR__ . '/view/field/*.php') as $field_view)
    require_once $field_view;
// and the file `sanitize/{field_name}.php`
// @see `class-sanitizer.php`

const NAME = 'cormorant_settings';
const GROUP = 'cormorant_settings_group';
const MENU_TITLE = 'Cormorant';
const PAGE_TITLE = 'Cormorant plugin settings';
const PAGE_SLUG = 'cormorant-settings';
const SECTIONS = [
    [
        'name' => 'cormorant_main_settings_section',
        'title' => 'E-mail confirmation',
        'fields' => [
            [
                // User will be redirected to this page after following the 
                // valid confirmation link.
                'name' => 'confirmation_page',
                'title' => 'Confirmation page',
            ],
            [
                // User will be redirected to this page when some errors 
                // causes during processing the request by confirmation link.
                'name' => 'confirmation_err_page',
                'title' => 'Confirmation error page',
            ],
        ],
    ],
];
