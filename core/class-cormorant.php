<?php

require_once CORMORANT_DIR . 'admin/class-admin.php';
require_once 'flamingo/flamingo.php';

// For `deactivate_plugins()`
require_once ABSPATH . 'wp-admin/includes/plugin.php';

class Cormorant
{
    private $admin;

    public function __construct()
    {
        $this->admin = new Admin();

        // Init this on WP init.
        add_action('init', [$this, 'init']);
    }

    /**
     * When WP finishes the plugin activation.
     */
    public function activate()
    {
        if (! flamingo\is_ok()) $this->off_due_to_flamingo();
    }

    /**
     * When WP finishes the plugin deactivation.
     */
    public function deactivate() {}

    /**
     * On WP init.
     */
    public function init()
    {
        flamingo\is_ok() ? $this->add_actions() : $this->off_due_to_flamingo();
    }

    private function add_actions()
    {
        // TODO
    }

    private function off_due_to_flamingo()
    {
        $this->admin->notice('Cormorant needs Flamingo');
        deactivate_plugins(CORMORANT);
    }
}
