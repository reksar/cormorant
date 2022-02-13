<?php namespace admin;

require_once 'notice/class-notice.php';

// For `deactivate_plugins()`
require_once ABSPATH . 'wp-admin/includes/plugin.php';

function deactivate_due_to_flamingo()
{
    new \admin\Notice('Cormorant needs Flamingo');
    deactivate_plugins(CORMORANT);
}
