<?php

class Test_Default_Value extends WP_UnitTestCase
{
    function test_for_most_types_is_empty_string()
    {
        $this->assertEquals('', \settings\default_value('email_subject'));
    }

    function test_for_page_select_is_0()
    {
        $this->assertEquals(0, \settings\default_value('confirmation_page'));
    }

    function test_for_number_is_0()
    {
        $this->assertEquals(0, \settings\default_value('days_to_confirm'));
    }
}
