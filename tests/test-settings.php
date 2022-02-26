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
