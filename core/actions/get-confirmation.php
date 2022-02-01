<?php namespace action\get_confirmation;

require_once CORMORANT_DIR . 'core/contact/class-contact.php';
require_once CORMORANT_DIR . 'core/contact/token.php';
require_once CORMORANT_DIR . 'core/err/class-bad-token.php';
require_once CORMORANT_DIR . 'core/err/class-no-contact.php';
require_once CORMORANT_DIR . 'core/err/class-not-same-id.php';

const HTTP_STATUS_MOVED_PERMANENTLY = 301;
const TOKEN_URL_PARAM = 'token';

// When an user follows the confirmation link from email and the WP GETs 
// a request with the `WP_ACTION`.
const WP_ACTION = 'confirm_email';
// Default action. For not authorized users.
const ON_CONFIRMATION = 'admin_post_nopriv_' . WP_ACTION;
// When some authorized WP user confirms email.
const ON_CONFIRMATION_AUTH = 'admin_post_' . WP_ACTION;

function init()
{
    add_action(ON_CONFIRMATION, '\action\get_confirmation\run');
    add_action(ON_CONFIRMATION_AUTH, '\action\get_confirmation\run');
}

/*
 * Extracts the token from GET request params, builds related `Contact` and
 * confirms it. Then redirects an user in corresponding to process status.
 */
function run()
{
    try
    {
        confirm_contact();
        redirect('confirmation_page');
    }
    catch (\err\Bad_Token | \err\No_Contact | \err\Not_Same_Id $err)
    {
        error_log($err->getMessage());
        redirect('confirmation_err_page');
    }
}

function confirm_contact()
{
    $token = token();
    if (! $token)
        throw new \err\Bad_Token($_GET[$token_name]);

    $email = \contact\token\email($token);
    $contact = new \Contact($email);

    $token_id = \contact\token\id($token);
    $contact_id = $contact->id();
    if ($token_id !== $contact_id)
        throw new \err\Not_Same_Id($contact_id, $token_id);

    $contact->confirm();
}

function token()
{
    return filter_input(INPUT_GET, TOKEN_URL_PARAM, FILTER_CALLBACK, [
        // Will pass urldecoded value to filter.
        'options' => '\contact\token\filter',
    ]);
}

function redirect($page_setting_name)
{
    $settings = get_option('cormorant_settings');
    $page_id = (int) $settings[$page_setting_name] ?? 0;
    $url = $page_id ? get_permalink($page_id) : home_url();
    wp_redirect($url, HTTP_STATUS_MOVED_PERMANENTLY);
}
