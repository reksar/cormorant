<?php namespace action\get_confirmation;
/**
 * This is an action module. The `init()` function is required for an action
 * to bind the action's features with the WP `add_action()`.
 */

// TODO: avoid circular requirements.
require_once CORMORANT_DIR . 'core/contact/contact.php';
require_once CORMORANT_DIR . 'core/contact/token.php';
require_once CORMORANT_DIR . 'core/err/class-bad-token.php';
require_once CORMORANT_DIR . 'core/err/class-no-contact.php';

use const \actions\TOKEN_URL_PARAM;

const HTTP_STATUS_MOVED_PERMANENTLY = 301;

function init()
{
    add_action(\actions\ON_CONFIRMATION, '\action\get_confirmation\run');
    add_action(\actions\ON_CONFIRMATION_AUTH, '\action\get_confirmation\run');
}

/*
 * Confirms a `Contact` with the token extracted from GET request.
 * Then redirects an user in corresponding to process status.
 */
function run()
{
    try
    {
        \contact\by_token(token())->confirm();
        redirect('confirmation_page');
    }
    catch (\err\Bad_Token | \err\No_Contact $err)
    {
        error_log($err->getMessage());
        redirect('confirmation_err_page');
    }
}

function token()
{
    return filter_input(INPUT_GET, TOKEN_URL_PARAM, FILTER_CALLBACK, [
        // Will pass urldecoded value to the filter.
        'options' => '\contact\token\filter',
    ]);
}

function redirect($page_setting_name)
{
    $page_id = \settings\get($page_setting_name);
    $url = $page_id ? get_permalink($page_id) : home_url();
    wp_redirect($url, HTTP_STATUS_MOVED_PERMANENTLY);
}
