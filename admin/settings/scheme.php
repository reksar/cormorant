<?php namespace settings;

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
