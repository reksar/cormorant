<?php namespace flamingo;

require_once ABSPATH . 'wp-content/plugins/flamingo/includes/class-contact.php';
require_once CORMORANT_DIR . 'core/contact/interface-contact.php';

class Contact implements \Contact
{
    public function __construct(array $form_data)
    {
    }

    public function is_confirmed(): bool
    {
        return false;
    }

    public function email(): string
    {
        return 'test@mail.com';
    }

    public function token(): string
    {
        return '12345';
    }
}
