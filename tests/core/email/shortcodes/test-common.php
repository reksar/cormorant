<?php

require_once CORMORANT_DIR . 'core/email/shortcodes/common.php';
use function shortcodes\basic;
use function shortcodes\meta;
use function shortcodes\fields;
use function shortcodes\common;

// Stub for an instance of the (array) `Flamingo_Inbound_Message`.
const MESSAGE = [
    'channel' => 'untitled',
    'submission_status' => 'mail_sent',
    'subject' => 'Some submitted subject',
    'from' => 'User Name <user@mail.my>',
    'from_name' => 'User Name',
    'from_email' => 'user@mail.my',
    'fields' => [
        'name' => 'Name',
        'user' => 'User',
        'birthday' => '1990-10-10',
        'phone' => 111222333444,
        'email' => 'user@mail.my',
        'textarea-field' => '...',
        'checkbox-field' => [
            '',
        ],
        'select-field' => [
            'selected item',
        ],
    ],
    'meta' => [
        'serial_number' => 9,
        'remote_ip' => '172.18.0.1',
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) ...',
        'url' => 'http://127.0.0.1:8000/?page_id=2',
        'date' => 'April 8, 2022',
        'time' => '3:29 am',
        'post_id' => 2,
        'post_name' => 'sample-page',
        'post_title' => 'Sample Page',
        'post_url' => 'http://127.0.0.1:8000/?page_id=2',
        'post_author' => 'admin',
        'post_author_email' => 'admin@mail.my',
        'site_title' => 'Cormorant',
        'site_description' => 'Just another WordPress site',
        'site_url' => 'http://127.0.0.1:8000',
        'site_admin_email' => 'admin@mail.my',
        'user_login' => '',
        'user_email' => '',
        'user_display_name' => '',
    ],
    'akismet' => '',
    'recaptcha' => [],
    'spam' => '',
    'spam_log' => [],
    'consent'=> [],
];

const EXPECTED_BASIC_SHORTCODES = [
    '[from_email]' => 'user@mail.my',
    '[from_name]' => 'User Name',
    '[subject]' => 'Some submitted subject',
];

const EXPECTED_META_SHORTCODES = [
    '[_date]' => 'April 8, 2022',
    '[_time]' => '3:29 am',
    '[_remote_ip]' => '172.18.0.1',
];

const EXPECTED_FIELD_SHORTCODES = [
    '[name]' => 'Name',
    '[user]' => 'User',
    '[birthday]' => '1990-10-10',
    '[phone]' => 111222333444,
    '[email]' => 'user@mail.my',
    '[textarea-field]' => '...',
    '[select-field]' => 'selected item',
];

class Test_Common_Shortcodes extends WP_UnitTestCase
{
    function test_basic()
    {
        $this->assertSameSetsWithIndex(
            EXPECTED_BASIC_SHORTCODES,
            basic(MESSAGE));
    }

    function test_meta()
    {
        $this->assertSameSetsWithIndex(
            EXPECTED_META_SHORTCODES,
            meta(MESSAGE));
    }

    function test_fields()
    {
        $this->assertSameSetsWithIndex(
            EXPECTED_FIELD_SHORTCODES,
            fields(MESSAGE));
    }

    function test_common()
    {
        $this->assertSameSetsWithIndex(
            array_merge(
                EXPECTED_FIELD_SHORTCODES,
                EXPECTED_META_SHORTCODES,
                EXPECTED_BASIC_SHORTCODES,
            ),
            common(MESSAGE));
    }
}
