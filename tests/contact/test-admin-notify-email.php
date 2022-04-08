<?php

require_once CORMORANT_DIR . 'core/contact/admin-notify-email.php';
use function contact\admin_notify_email\common_shortcodes;
use function contact\admin_notify_email\meta_shortcodes;
use function contact\admin_notify_email\field_shortcodes;
use function contact\admin_notify_email\all_shortcodes;
use function contact\admin_notify_email\dict_to_pairs;
use function contact\admin_notify_email\replace_shortcode;

// Stub for an instance of the `Flamingo_Inbound_Message` class.
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
            '0' => '',
        ],
        'select-field' => [
            '0' => '1st item',
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

const EXPECTED_COMMON_SHORTCODES = [
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
];

class Test_Admin_Notify_Email extends WP_UnitTestCase
{
    function test_common_shortcodes()
    {
        $this->assertSameSetsWithIndex(
            EXPECTED_COMMON_SHORTCODES,
            common_shortcodes(MESSAGE));
    }

    function test_meta_shortcodes()
    {
        $this->assertSameSetsWithIndex(
            EXPECTED_META_SHORTCODES,
            meta_shortcodes(MESSAGE));
    }

    function test_field_shortcodes()
    {
        $this->assertSameSetsWithIndex(
            EXPECTED_FIELD_SHORTCODES,
            field_shortcodes(MESSAGE));
    }

    function test_all_shortcodes()
    {
        $this->assertSameSetsWithIndex(
            array_merge(
                EXPECTED_FIELD_SHORTCODES,
                EXPECTED_META_SHORTCODES,
                EXPECTED_COMMON_SHORTCODES,
            ),
            all_shortcodes(MESSAGE));
    }

    function test_dict_to_pairs()
    {
        $dict = [
            'item 1' => 'some value',
            'item 2' => 'yet another value',
            3 => 4,
            'nested array' => [1, 2, 3],
        ];
        $expected_pairs = [
            ['item 1', 'some value'],
            ['item 2', 'yet another value'],
            [3, 4],
            ['nested array', [1, 2, 3]],
        ];
        $actual_pairs = dict_to_pairs($dict);
        $this->assertEqualSets($expected_pairs, $actual_pairs);
    }

    function test_replace_shortcode()
    {
        $template = 'This is [shortcode-name]';
        $shortcode = '[shortcode-name]';
        $value = 'replacement text';
        $expected_text = 'This is replacement text';
        $actual_text = replace_shortcode($template, [$shortcode, $value]);
        $this->assertEquals($expected_text, $actual_text);
    }
}
