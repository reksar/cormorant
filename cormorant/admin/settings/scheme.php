<?php namespace settings;

// The whole Cormorant WP settings page.
require_once 'view/settings.php';

// Each section, described in the `SECTIONS` const below, requires the file
// `view/section/{section_name}.php`
foreach (glob(__DIR__ . '/view/section/*.php') as $section_view)
    require_once $section_view;

// Each field, described in the section's `fields` array, requires the file
// `view/field/{field_name}.php`
foreach (glob(__DIR__ . '/view/field/*.php') as $field_view)
    require_once $field_view;
// and the file `sanitize/{field_name}.php`
foreach (glob(__DIR__ . '/sanitize/*.php') as $sanitizer)
    require_once $sanitizer;

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
                'default' => 0, // home page id
            ],
            [
                // User will be redirected to this page when some errors 
                // causes during processing the request by confirmation link.
                'name' => 'confirmation_err_page',
                'title' => 'Confirmation error page',
                'default' => 0, // home page id
            ],
            [
                'name' => 'email_subject',
                'title' => 'Confirmation e-mail subject',
            ],
            [
                'name' => 'email_template',
                'title' => 'Confirmation e-mail template',
            ],
            [
                'name' => 'notify_admin_on_confirmation',
                'title' => 'Notify admin on a contact confirmation',
            ],
            [
                // Flamingo contacts and related messages will be deleted if
                // they are not confirmed within this time.
                // Set to 0 to prevent automatic contacts cleaning.
                'name' => 'days_to_confirm',
                'title' => 'Days to confirm a contact',
                'default' => 0,
                'max' => 365,
            ],
        ],
    ],
];
