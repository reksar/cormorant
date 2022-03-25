<?php

class Test_Settings_Common extends WP_UnitTestCase
{
    function test_all_checkbox_names()
    {
        $this->assertEqualSets(\settings\all_checkbox_names(), [
            'notify_admin_on_confirmation',
        ]);
    }
}
