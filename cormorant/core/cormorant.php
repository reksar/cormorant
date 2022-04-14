<?php namespace cormorant;

require_once CORMORANT_DIR . 'admin/settings/settings.php';
require_once CORMORANT_DIR . 'admin/admin.php';
require_once 'flamingo.php';
require_once 'actions/actions.php';

/*
 * On WP init. Main features of the Cormorant plugin.
 */
function init()
{
    if (\flamingo\is_active()) {
        \flamingo\init();
        \settings\init();
        \actions\init();
    }
    else \admin\deactivate_due_to_flamingo();
}

/*
 * When WP finishes the plugin activation.
 */
function activate()
{
    if (\flamingo\is_active())
        \contact\tag\confirmed\create();
    else
        \admin\deactivate_due_to_flamingo();
}

/*
 * When WP finishes the plugin deactivation.
 */
function deactivate()
{
    // This method may be invoked during the plugin activation if the 
    // plugin deactivates self due to errors.
    //
    // This hack prevents showing the notice about the plugin activation 
    // success in this case.
    //
    // @see wp-admin/plugins.php
    unset($_GET['activate']);
}
