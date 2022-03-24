<?php

define('ALL_FIELDS', ...array_merge(array_map(

    function($section) {
        return $section['fields'];
    },

    settings\SECTIONS)));

/**
 * Each settings field must have params:
 *   - name
 *   - title
 *   - input_type
 */
class Test_Required_Field_Params extends WP_UnitTestCase
{
    function test_all_fields_have_name()
    {
        foreach (ALL_FIELDS as $field)
            $this->assertArrayHasKey('name', $field);
    }

    function test_all_fields_have_title()
    {
        foreach (ALL_FIELDS as $field)
            $this->assertArrayHasKey('title', $field);
    }

    function test_all_fields_have_input_type()
    {
        foreach (ALL_FIELDS as $field)
            $this->assertArrayHasKey('input_type', $field);
    }
}

class Test_Settings_Field_Function extends WP_UnitTestCase
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
