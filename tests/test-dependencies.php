<?php

class Test_Dependencies extends WP_UnitTestCase
{
    function test_cormorant_plugin_exists()
    {
        $this->assertArrayHasKey(\test\CORMORANT_PLUGIN, get_plugins());
    }

    function test_flamingo_plugin_exists()
    {
        $this->assertArrayHasKey(\test\FLAMINGO_PLUGIN, get_plugins());
    }

    function test_cf7_plugin_exists()
    {
        $this->assertArrayHasKey(\test\CF7_PLUGIN, get_plugins());
    }
}
