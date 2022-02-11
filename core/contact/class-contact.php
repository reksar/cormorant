<?php

require_once 'token.php';
require_once 'confirmation-email.php';
require_once CORMORANT_DIR . 'core/flamingo.php';
require_once CORMORANT_DIR . 'core/err/class-bad-token.php';

/*
 * Adapter for the `Flamingo_Contact`.
 */
class Contact
{
    const TAG_CONFIRMED = 'confirmed';

    private $id;
    private $email;

    public static function from_email($email)
    {
        return new self(\flamingo\contact($email));
    }

    public static function from_token($token)
    {
        if (! $token)
            throw new \err\Bad_Token($token);

        $id = \contact\token\id($token);
        $email = \contact\token\email($token);
        $flamingo_contact = \flamingo\contact($email);

        if ($flamingo_contact->id() !== $id)
            throw new \err\Bad_Token($token);

        return new self($flamingo_contact);
    }

    public function __construct($flamingo_contact)
    {
        $this->id = $flamingo_contact->id();
        $this->email = $flamingo_contact->email;
    }

    public function id()
    {
        return $this->id;
    }

    public function email()
    {
        return $this->email;
    }

    public function token()
    {
        return \contact\token\from_contact($this);
    }

    public function is_confirmed()
    {
        return in_array(self::TAG_CONFIRMED, $this->tags());
    }

    public function confirm()
    {
        if (! $this->is_confirmed())
            $this->add_tag(self::TAG_CONFIRMED);
    }

    public function ask_confirmation()
    {
        if (! $this->is_confirmed())
            \contact\confirmation_email\send($this);
    }

    public function tags()
    {
        return \flamingo\tags($this->id);
    }

    public function add_tag($tag)
    {
        \flamingo\add_tag($tag, $this->id);
    }
}
