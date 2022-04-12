<?php

require_once CORMORANT_DIR . 'admin/settings/field/sanitize/confirmed_tag.php';

class Test_Sanitize_Confirmed_Tag extends WP_UnitTestCase
{
    function test_valid_alphabet()
    {
        $tag = 'name';
        $this->assertEquals($tag, \sanitize\confirmed_tag($tag));

        $tag = 'Name';
        $this->assertEquals($tag, \sanitize\confirmed_tag($tag));
    }

    function test_valid_alnum()
    {
        $tag = 'name2';
        $this->assertEquals($tag, \sanitize\confirmed_tag($tag));
    }

    function test_dash_is_valid_separator()
    {
        $tag = 'dash-as-separator';
        $this->assertEquals($tag, \sanitize\confirmed_tag($tag));

        $tag = 'count-1-2-3';
        $this->assertEquals($tag, \sanitize\confirmed_tag($tag));

        $tag = '1-2-3-count';
        $this->assertEquals($tag, \sanitize\confirmed_tag($tag));
    }

    function test_valid_number()
    {
        $this->assertEquals('10', \sanitize\confirmed_tag(10));
    }

    function test_spaces_are_disallowed()
    {
        $this->assertFalse(\sanitize\confirmed_tag('contains space'));
    }

    function test_other_chars_are_disallowed()
    {
        $this->assertFalse(\sanitize\confirmed_tag('dot.'));
        $this->assertFalse(\sanitize\confirmed_tag('@'));
    }
}
