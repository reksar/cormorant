<?php

require_once 'token.php';
// TODO: avoid circular requirements.
require_once 'confirmation-email.php';
require_once CORMORANT_DIR . 'core/flamingo.php';

require_once CORMORANT_DIR . 'core/actions/interface.php';
use const \actions\ON_CONFIRM;

/*
 * Adapter for the `Flamingo_Contact`.
 */
class Contact
{
    const TAG_CONFIRMED = 'confirmed';

    private $contact;

    public function __construct($flamingo_contact)
    {
        $this->contact = $flamingo_contact;
    }

    public function id()
    {
        return $this->contact->id();
    }

    public function email()
    {
        return $this->contact->email;
    }

    public function token()
    {
        return \contact\token\from_contact($this);
    }

    public function ask_confirmation()
    {
        if (! $this->is_confirmed())
            \contact\confirmation_email\send($this);
    }

    public function confirm()
    {
        if (! $this->is_confirmed()) {
            $this->add_tag(self::TAG_CONFIRMED);
            do_action(\actions\ON_CONFIRM, $this);
        }
    }

    public function delete()
    {
        $this->contact->delete();
    }

    public function delete_related_messages()
    {
        foreach (\flamingo\find_messages_from($this->email()) as $message)
            $message->delete();
    }

    public function is_confirmed()
    {
        return in_array(self::TAG_CONFIRMED, $this->tags());
    }

    public function tags()
    {
        return $this->contact->tags;
    }

    public function add_tag($tag)
    {
        $this->contact->tags[] = $tag;
        $this->contact->save();
    }
}
