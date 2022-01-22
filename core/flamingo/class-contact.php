<?php namespace flamingo;

require_once WP_CONTENT_DIR . '/plugins/flamingo/includes/class-contact.php';
require_once CORMORANT_DIR . 'core/contact/interface-contact.php';
require_once 'class-err-no-contact.php';

/*
 * Adapter for the `Flamingo_Contact` from the original Flamingo plugin.
 */
class Contact implements \Contact
{
    private $flamingo_contact;

    public function __construct(string $email)
    {
        // The `Flamingo_Contact::search_by_email()` returns one of existing 
        // contacts even we searching by empty email, so we must do this first.
        if (! $email) throw new Err_No_Contact($email);

        $this->flamingo_contact = \Flamingo_Contact::search_by_email($email);

        // Current Flamingo version returns `NULL` if can't find a contact by 
        // email.
        if (! $this->flamingo_contact) throw new Err_No_Contact($email);
    }

    public function is_confirmed(): bool
    {
        return false;
    }

    public function email(): string
    {
        // Yes, it is public. Takayuki is risky dude :)
        return $this->flamingo_contact->email;
    }

    public function token(): string
    {
        $salt = (string) $this->flamingo_contact->id();
        $payload = $this->email() . ':' . $salt;
        return base64_encode($payload);
    }
}
