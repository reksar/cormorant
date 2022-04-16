<?php

require_once CORMORANT_DIR . 'core/email/shortcodes/confirmation-link.php';
use function shortcodes\confirmation_link;
use function shortcodes\confirmation_link_url;
use function shortcodes\confirmation_link_tail;

// TODO: check is urlencoded.
const TOKEN = 'this-is-token';
const LINK_TAIL = 'admin-post.php?action=confirm_email&token=this-is-token';
const ADMIN_URL = 'http://example.org/wp-admin/';
const URL = ADMIN_URL . LINK_TAIL;

class Test_Confirmation_Link_Shortcode extends WP_UnitTestCase
{
    function test_confirmation_link_is_dict_of_one_item()
    {
        $shortcode = confirmation_link(TOKEN);
        $this->assertCount(1, $shortcode);

        $key = \shortcodes\CONFIRMATION_LINK;
        $this->assertContains($key, array_keys($shortcode));
    }

    function test_link_url()
    {
        $this->assertEquals(URL, confirmation_link_url(TOKEN));
    }

    /**
     * Takes into account an actions constants, so it may fail because of this.
     */
    function test_link_url_tail()
    {
        $this->assertEquals(LINK_TAIL, confirmation_link_tail(TOKEN));
    }
}
