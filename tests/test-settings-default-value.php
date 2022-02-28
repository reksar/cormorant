<?php

class Test_Default_Value extends WP_UnitTestCase
{
    function test_default_values()
    {
        $this->assertEquals(0, \settings\default_value('confirmation_page'));
        $this->assertEquals('', \settings\default_value('email_subject'));
    }
}
