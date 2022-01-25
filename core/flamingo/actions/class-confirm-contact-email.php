<?php namespace flamingo\action;

require_once CORMORANT_DIR . 'core/contact/class-confirmation-email.php';
require_once CORMORANT_DIR . 'core/flamingo/contact.php';
require_once CORMORANT_DIR . 'core/flamingo/token.php';
require_once CORMORANT_DIR . 'core/flamingo/err/class-bad-token.php';

use \flamingo\contact as contact;

class Confirm_Contact_Email
{
    public function __construct()
    {
        $action = \Confirmation_Email::ACTION;
        add_action("admin_post_$action", $this);
        add_action("admin_post_nopriv_$action", $this);
    }

    public function __invoke()
    {
        try
        {
            contact\by_token(self::token())->confirm();
            // TODO: redirect to OK page
        }
        catch (
            \err\No_Contact |
            \err\Different_Token_Id |
            \err\Bad_Token $err)
        {
            error_log($err->getMessage());
            // TODO: redirect to ERR page
        }
    }

    private static function token(): string
    {
        $token_name = \Confirmation_Email::TOKEN_NAME;
        $token = filter_input(INPUT_GET, $token_name, FILTER_CALLBACK, [
            // Will pass urldecoded token value.
            'options' => '\flamingo\contact\token\filter',
        ]);

        if (! $token) throw new \err\Bad_Token($_GET[$token_name]);

        return $token;
    }
}
