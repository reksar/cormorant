<?php namespace flamingo\action;

require_once CORMORANT_DIR . 'core/contact/class-confirmation-email.php';
require_once CORMORANT_DIR . 'core/flamingo/contact.php';
require_once CORMORANT_DIR . 'core/flamingo/token.php';

use \flamingo\contact as contact;
use \flamingo\contact\token as token;

class Confirm_Contact_Email
{
    const ACTION = 'confirm_email';

    public function __construct()
    {
        add_action('admin_post_nopriv_' . self::ACTION, $this);
        add_action('admin_post_' . self::ACTION, $this);
    }

    public function __invoke()
    {
        $token = filter_input(INPUT_GET, 'token', FILTER_CALLBACK, [
            'options' => 'token\filter',
        ]);

        try {
            contact\by_token($token)->confirm();
            // TODO: redirect to OK page
        }
        catch (\err\No_Contact | \err\Different_Token_Id  $e) {
            error_log($e->getMessage());
            // TODO: redirect to ERR page
        }
    }
}
