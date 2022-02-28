<?php

class Test_Settings_Field extends WP_UnitTestCase
{
    function test_confirmation_page()
    {
        $confirmation_page = \settings\field('confirmation_page');
        $this->assertArrayHasKey('name', $confirmation_page);
        $this->assertArrayHasKey('title', $confirmation_page);
        $this->assertArrayHasKey('default', $confirmation_page);
    }

    function test_email_subject()
    {
        $email_subject = \settings\field('email_subject');
        $this->assertArrayHasKey('name', $email_subject);
        $this->assertArrayHasKey('title', $email_subject);
    }

    function test_days_to_confirm()
    {
        $days_to_confirm = \settings\field('days_to_confirm');
        $this->assertArrayHasKey('name', $days_to_confirm);
        $this->assertArrayHasKey('title', $days_to_confirm);
        $this->assertArrayHasKey('max', $days_to_confirm);
    }
}
