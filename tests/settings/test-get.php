<?php

trait Common
{
    function set_value($value)
    {
        assert(update_option(\settings\NAME, [
            self::NAME => $value,
        ]));
    }

    function actual_value()
    {
        return \settings\get(self::NAME);
    }
}

class Test_Confirmation_Page extends WP_UnitTestCase
{
    use Common;

    const NAME = 'confirmation_page';
    const DEFAULT_VALUE = 0; // home page index

    function test_get_default()
    {
        $this->assertEquals($this->actual_value(), self::DEFAULT_VALUE);
    }

    function test_get_valid_value()
    {
        $valid_value = 1; // some page index
        $this->set_value($valid_value);

        $this->assertEquals($this->actual_value(), $valid_value);
    }

    function test_get_invalid_value_gives_default()
    {
        $invalid_value = 'invalid'; // must be int
        $this->set_value($invalid_value);

        $this->assertEquals($this->actual_value(), self::DEFAULT_VALUE);
    }
}

class Test_Confirmation_Err_Page extends WP_UnitTestCase
{
    use Common;

    const NAME = 'confirmation_err_page';
    const DEFAULT_VALUE = 0; // home page index

    function test_get_default()
    {
        $this->assertEquals($this->actual_value(), self::DEFAULT_VALUE);
    }

    function test_get_valid_value()
    {
        $valid_value = 1; // some page index
        $this->set_value($valid_value);

        $this->assertEquals($this->actual_value(), $valid_value);
    }

    function test_get_invalid_value_gives_default()
    {
        $invalid_value = 'invalid'; // must be int
        $this->set_value($invalid_value);

        $this->assertEquals($this->actual_value(), self::DEFAULT_VALUE);
    }
}

class Test_Email_Subject extends WP_UnitTestCase
{
    use Common;

    const NAME = 'email_subject';
    const DEFAULT_VALUE = '';

    function test_get_default()
    {
        $this->assertEquals($this->actual_value(), self::DEFAULT_VALUE);
    }

    function test_get_valid_string()
    {
        $valid_string = 'some subject';

        $this->set_value($valid_string);

        $this->assertEquals($this->actual_value(), $valid_string);
    }

    function test_int_will_be_converted_to_string()
    {
        $int_value = 123;
        $str_value = '123';

        $this->set_value($int_value);

        $this->assertEquals($this->actual_value(), $str_value);
    }

    function test_raw_string_will_be_sanitized()
    {
        $raw = "some \r\n subject";
        $sanitized = 'some subject';

        $this->set_value($raw);

        $this->assertEquals($this->actual_value(), $sanitized);
    }
}

class Test_Email_Template extends WP_UnitTestCase
{
    use Common;

    const NAME = 'email_template';
    const DEFAULT_VALUE = '';

    function test_get_default()
    {
        $this->assertEquals($this->actual_value(), self::DEFAULT_VALUE);
    }

    function test_get_multiline()
    {
        $multiline = "Line 1.\n" .
            "Line 2.";

        $this->set_value($multiline);

        $this->assertEquals($this->actual_value(), $multiline);
    }

    function test_placeholder_is_still()
    {
        $text_with_placeholder = "Some text\n" .
            'that contains a [some-placeholder]';

        $this->set_value($text_with_placeholder);

        $this->assertEquals($this->actual_value(), $text_with_placeholder);
    }

    function test_html()
    {
        $html = "<title>Some title</title>\n" .
            '<p>Some text</p>';

        $this->set_value($html);

        $this->assertEquals($this->actual_value(), $html);
    }

    function test_html_and_placeholders()
    {
        $template = "<title>The email HTML template</title>\n" .
            "<p>that contains the <b>placeholder</b> with the</p>\n" .
            '<p>email confirmation link: [confirmation-link]</p>';

        $this->set_value($template);

        $this->assertEquals($this->actual_value(), $template);
    }

    function test_int_will_be_converted_to_string()
    {
        $int_value = 123;
        $str_value = '123';

        $this->set_value($int_value);

        $this->assertEquals($this->actual_value(), $str_value);
    }
}

class Test_Notify_On_Confirmation extends WP_UnitTestCase
{
    use Common;

    const NAME = 'notify_admin_on_confirmation';
    // Not checked checkbox.
    const DEFAULT_VALUE = 0;
    // This is the only valid value except the dafult.
    const CHECKED = 1;

    function test_get_default()
    {
        $this->assertEquals($this->actual_value(), self::DEFAULT_VALUE);
    }

    function test_get_valid_value()
    {
        $this->set_value(self::CHECKED);
        $this->assertEquals($this->actual_value(), self::CHECKED);
    }

    function test_positive_int_gives_checked()
    {
        $positive_int = 123;
        $this->set_value($positive_int);
        $this->assertEquals($this->actual_value(), self::CHECKED);
    }

    function test_negative_int_gives_checked()
    {
        $negative_int = -123;
        $this->set_value($negative_int);
        $this->assertEquals($this->actual_value(), self::CHECKED);
    }

    function test_empty_string_gives_default()
    {
        $empty_string = '';
        $this->set_value($empty_string);
        $this->assertEquals($this->actual_value(), self::DEFAULT_VALUE);
    }

    function test_not_empty_string_gives_checked()
    {
        $not_empty_string = '123';
        $this->set_value($not_empty_string);
        $this->assertEquals($this->actual_value(), self::CHECKED);
    }
}
