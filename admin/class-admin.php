<?php

require_once 'notice/class-notice.php';
require_once 'settings/class-settings.php';

/**
 * Features for the WP admin context.
 */
class Admin
{
    public function __construct()
    {
        new Settings();
    }

    public function notice($text)
    {
        new Notice($text);
    }
}
