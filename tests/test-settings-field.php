<?php
// TODO: check required params for all settings fields.

class Test_Settings_Field extends WP_UnitTestCase
{
    function test_email_subject()
    {
        $email_subject = \settings\field('email_subject');
        $this->assertArrayHasKey('name', $email_subject);
        $this->assertArrayHasKey('title', $email_subject);
        $this->assertArrayHasKey('input_type', $email_subject);
    }

    function test_days_to_confirm()
    {
        $days_to_confirm = \settings\field('days_to_confirm');
        $this->assertArrayHasKey('name', $days_to_confirm);
        $this->assertArrayHasKey('title', $days_to_confirm);
        $this->assertArrayHasKey('input_type', $days_to_confirm);
        $this->assertArrayHasKey('options', $days_to_confirm);

        $options = $days_to_confirm['options'];
        $this->assertArrayHasKey('default', $options);
        $this->assertArrayHasKey('max', $options);
    }
}
