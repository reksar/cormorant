<?php namespace flamingo;

require_once WP_CONTENT_DIR . '/plugins/flamingo/includes/class-contact.php';
require_once CORMORANT_DIR . 'core/contact/interface-contact.php';
require_once 'token.php';

use \flamingo\contact\token as token;

/*
 * Adapter for the `Flamingo_Contact` from the original Flamingo plugin.
 */
class Contact implements \Contact
{
    private \Flamingo_Contact $contact;

    public function __construct(\Flamingo_Contact $contact)
    {
        $this->contact = $contact;
    }

    public function id(): int
    {
        return $this->contact->id();
    }

    public function email(): string
    {
        // Yes, it is public. Takayuki is risky dude :)
        return $this->contact->email;
    }

    public function token(): string
    {
        return token\from_contact($this);
    }

    public function is_confirmed(): bool
    {
        return false;
    }

    public function confirm()
    {
    }
}
