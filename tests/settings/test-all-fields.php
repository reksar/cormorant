<?php

use const \settings\ALL_FIELDS as ALL_FIELDS;

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
