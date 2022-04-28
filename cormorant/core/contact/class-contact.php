<?php

require_once 'token.php';
require_once CORMORANT_DIR . 'core/flamingo.php';

require_once 'tag/confirmed.php';
use const \contact\tag\confirmed\SLUG as CONFIRMED_TAG_SLUG;
use function \contact\tag\confirmed\name as confirmed_tag_name;

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

    public function name()
    {
        return $this->contact->name;
    }

    public function token()
    {
        return \contact\token\from_contact($this);
    }

    public function confirm()
    {
        $this->add_tag(CONFIRMED_TAG_SLUG);
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
        return in_array(confirmed_tag_name(), $this->tag_names());
    }

    public function tag_names()
    {
        return $this->contact->tags;
    }

    /**
     * Uses the `wp_set_object_terms()` under the hood, so
     * @param tag - either ID or slug.
     * @see https://developer.wordpress.org/reference/functions/wp_set_object_terms
     */
    public function add_tag($tag)
    {
        $this->contact->tags[] = $tag;
        $this->contact->save();
    }
}
