<?php

require_once CORMORANT_DIR . 'core/contact/shortcodes/utils.php';
use function shortcodes\map_keys;
use function shortcodes\replace;
use function shortcodes\replace_pair;
use function shortcodes\dict_to_pairs;

class Test_Shortcodes_Utils extends WP_UnitTestCase
{
    function test_map_keys()
    {
        $dict = [
            'key 1' => 1,
            'key 2' => '2',
            'last key' => 'last value',
        ];

        // Same as `array_change_key_case()`.
        $this->assertSameSetsWithIndex([
                'KEY 1' => 1,
                'KEY 2' => '2',
                'LAST KEY' => 'last value',
            ],
            map_keys('strtoupper', $dict));

        // Transform dict to list. The `array_is_list()` gives `true` in PHP8.
        // Same as `array_values()`.
        $list = map_keys(function($key) {static $i = 0; return $i++;}, $dict);
        $this->assertSameSetsWithIndex([
                0 => 1,
                1 => '2',
                2 => 'last value',
            ],
            $list);

        // Transform list to dict.
        // Same as `array_combine(keys, values)`.
        $this->assertSameSetsWithIndex([
                'item 0' => 1,
                'item 1' => '2',
                'item 2' => 'last value',
            ],
            map_keys(function($key) {return "item $key";}, $list));
    }

    function test_replace()
    {
        $template = 'Here is [first-shortcode], then here is ' .
            '[second-shortcode] and this is *[second-shortcode]* too.';

        $expected_text = 'Here is first value, then here is ' .
            'second value and this is *second value* too.';

        $shortcodes = [
            '[first-shortcode]' => 'first value',
            '[second-shortcode]' => 'second value',
        ];

        $actual_text = replace($shortcodes, $template);
        $this->assertEquals($expected_text, $actual_text);
    }

    function test_replace_pair()
    {
        $template = 'This is [will-be-replaced] ' .
            'and this is [will-be-replaced] too. But this [is-not].';

        $expected_text = 'This is replacement text ' .
            'and this is replacement text too. But this [is-not].';

        $shortcode = '[will-be-replaced]';
        $value = 'replacement text';
        $pair = [$shortcode, $value];
        $actual_text = replace_pair($template, $pair);
        $this->assertEquals($expected_text, $actual_text);
    }

    function test_dict_to_pairs()
    {
        $dict = [
            'item 1' => 'some value',
            'item 2' => 'yet another value',
            3 => 4,
            'nested array' => [1, 2, 3],
        ];
        $this->assertEqualSets([
                ['item 1', 'some value'],
                ['item 2', 'yet another value'],
                [3, 4],
                ['nested array', [1, 2, 3]],
            ],
            dict_to_pairs($dict));
    }
}
