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

    private $flamingo_contact;

    // TODO: move
    public static function from_email($email)
    {
        return new self(\flamingo\contact($email));
    }

    // TODO: move
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
        $this->flamingo_contact = $flamingo_contact;
    }

    public function id()
    {
        return $this->flamingo_contact->id();
    }

    public function email()
    {
        return $this->flamingo_contact->email;
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
        return $this->flamingo_contact->tags;
    }

    public function add_tag($tag)
    {
        $this->flamingo_contact->tags[] = $tag;
        $this->flamingo_contact->save();
    }

    public function delete()
    {
        $this->flamingo_contact->delete();
    }

    public function delete_related_messages()
    {
        foreach (\flamingo\find_messages_from($this->email()) as $message)
            $message->delete();
    }
}
