<?php

require_once 'settings/settings.php';
require_once 'notice/class-notice.php';

/**
 * Features for the WP admin context.
 */
class Admin
{
    public function __construct()
    {
        settings\init();
    }

    public function notice($text)
    {
        new Notice($text);
    }
}
