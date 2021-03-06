<?php namespace settings;

require_once CORMORANT_DIR . 'core/contact/tag/confirmed.php';

// The whole Cormorant WP settings page.
require_once 'view/settings.php';

// Each section, described in the `SECTIONS` const below, requires the file
// `view/section/{section_name}.php`
foreach (glob(__DIR__ . '/view/section/*.php') as $section_view)
    require_once $section_view;

// Each field, described in the section's `fields`, requires
// the file `field/view/{field_name}.php`
foreach (glob(__DIR__ . '/field/view/*.php') as $field_view)
    require_once $field_view;
// and the file `field/sanitize/{field_name}.php`
foreach (glob(__DIR__ . '/field/sanitize/*.php') as $sanitizer)
    require_once $sanitizer;
// and this is optional:
foreach (glob(__DIR__ . '/field/update/*.php') as $hook)
    require_once $hook;

const NAME = 'cormorant_settings';
const GROUP = 'cormorant_settings_group';
const MENU_TITLE = 'Cormorant';
const PAGE_TITLE = 'Cormorant plugin settings';
const PAGE_SLUG = 'cormorant-settings';

// Required params for each section:
//  - name
//  - title
//  - fields
//
// Required params for each field:
//  - name
//  - title
//  - input_type
// Optional params, specific to `input_type`, can be described in `options`
// nested array.
const SECTIONS = [
    [
        'name' => 'cormorant_main_settings_section',
        'title' => 'E-mail confirmation',
        'fields' => [
            [
                'name' => \contact\tag\confirmed\SETTING_NAME,
                'title' => 'Confirmed tag',
                'input_type' => 'text',
                'options' => [
                    'default' => \contact\tag\confirmed\DEFAULT_NAME,
                ],
            ],
            [
                'name' => 'email_subject',
                'title' => 'Confirmation email subject',
                'input_type' => 'text',
            ],
            [
                'name' => 'email_template',
                'title' => 'Confirmation email template',
                'input_type' => 'textarea',
            ],
            [
                'name' => 'notify_admin_on_confirmation',
                'title' => 'Notify admin on a contact confirmation',
                'input_type' => 'checkbox',
            ],
            [
                'name' => 'notify_email_subject',
                'title' => 'Notify email subject',
                'input_type' => 'text',
            ],
            [
                'name' => 'notify_email_template',
                'title' => 'Notify email template',
                'input_type' => 'textarea',
            ],
            [
                // User will be redirected to this page after following the
                // valid confirmation link.
                'name' => 'confirmation_page',
                'title' => 'Confirmation page',
                'input_type' => 'page_select',
            ],
            [
                // User will be redirected to this page when some errors
                // causes during processing the request by confirmation link.
                'name' => 'confirmation_err_page',
                'title' => 'Confirmation error page',
                'input_type' => 'page_select',
            ],
            [
                // Flamingo contacts and related messages will be deleted if
                // they are not confirmed within this time.
                // Set to 0 to prevent automatic contacts cleaning.
                'name' => 'days_to_confirm',
                'title' => 'Days to confirm a contact',
                'input_type' => 'number',
                'options' => [
                    'min' => 0,
                    'max' => 365,
                ],
            ],
        ],
    ],
];
