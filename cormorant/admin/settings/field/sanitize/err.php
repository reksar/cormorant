<?php namespace sanitize;

const ADD_ERR = '\add_settings_error';

/**
 * Add error message that will be shown after submitting WP settings.
 */
function err($setting_name, $message)
{
    // The `ADD_ERR` function exists when settings are submitted.
    // The `err()` function is used in the settings sanitizers.
    // Sanitizers may be used to view settings without editing.
    // So this check prevents an error showing in this case.
    if (function_exists(ADD_ERR))
        call_user_func(ADD_ERR, \settings\NAME, $setting_name, $message);
}
