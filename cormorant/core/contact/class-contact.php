<?php

require_once 'token.php';
require_once CORMORANT_DIR . 'core/flamingo.php';

require_once 'tag/confirmed.php';
use const \contact\tag\confirmed\SLUG as CONFIRMED_TAG;

/*
 * `Flamingo_Contact` wrapper.
 */
class Contact
{
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

    public function confirm()
    {
        $this->add_tag(CONFIRMED_TAG);
    }

    public function delete()
    {
        $this->contact->delete();
    }

    public function related_messages()
    {
        return \flamingo\find_messages_from($this->email());
    }

    public function is_confirmed()
    {
        return in_array(CONFIRMED_TAG, $this->tags());
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
