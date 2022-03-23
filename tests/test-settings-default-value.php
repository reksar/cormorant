<?php

class Test_Default_Value extends WP_UnitTestCase
{
    function test_default_values()
    {
        // Must be 0 for page_select.
        $this->assertEquals(0, \settings\default_value('confirmation_page'));
        // Must be 0 for number.
        $this->assertEquals(0, \settings\default_value('days_to_confirm'));
        // Must be empty string for other types.
        $this->assertEquals('', \settings\default_value('email_subject'));
    }
}
