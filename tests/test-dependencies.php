<?php

require_once TESTS_DIR . '/const.php';
use const \test\CORMORANT_PLUGIN as CORMORANT_PLUGIN;
use const \test\FLAMINGO_PLUGIN as FLAMINGO_PLUGIN;
use const \test\CF7_PLUGIN as CF7_PLUGIN;

class Test_Dependencies extends WP_UnitTestCase
{
    function test_cormorant_plugin_exists()
    {
        $this->assertArrayHasKey(CORMORANT_PLUGIN, get_plugins());
    }

    function test_flamingo_plugin_exists()
    {
        $this->assertArrayHasKey(FLAMINGO_PLUGIN, get_plugins());
    }

    function test_cf7_plugin_exists()
    {
        $this->assertArrayHasKey(CF7_PLUGIN, get_plugins());
    }
}
