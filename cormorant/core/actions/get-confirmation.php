<?php namespace action\get_confirmation;

require_once 'interface.php';
use const \actions\TOKEN_URL_PARAM;
use const \actions\ON_CONFIRMATION;
use const \actions\ON_CONFIRMATION_AUTH;
use const \actions\ON_CONFIRM;

require_once CORMORANT_DIR . 'core/contact/contact.php';
require_once CORMORANT_DIR . 'core/contact/token.php';
require_once CORMORANT_DIR . 'core/err/class-bad-token.php';
require_once CORMORANT_DIR . 'core/err/class-no-contact.php';

const RUN = __NAMESPACE__ . '\run';
const HTTP_MOVED_PERMANENTLY = 301;

function init()
{
    add_action(ON_CONFIRMATION, RUN);
    add_action(ON_CONFIRMATION_AUTH, RUN);
}

/*
 * Confirms a `Contact` with the token extracted from GET request params.
 * Then redirects an user in corresponding to process status.
 */
function run()
{
    try
    {
        confirm(\contact\by_token(token()));
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
    wp_redirect($url, HTTP_MOVED_PERMANENTLY);
}

function confirm($contact)
{
    if (! $contact->is_confirmed()) {
        $contact->confirm();
        do_action(ON_CONFIRM, $contact);
    }
}
