<?php

require_once WP_PLUGIN_DIR . '/flamingo/includes/class-contact.php';
require_once CORMORANT_DIR . 'core/err/class-no-contact.php';
require_once 'token.php';

/*
 * Adapter for the `Flamingo_Contact` from the original Flamingo plugin.
 */
class Contact
{
    const TAG_TAXONOMY = Flamingo_Contact::contact_tag_taxonomy;
    const TAG_CONFIRMED = 'confirmed';

    private $id;
    private $email;

    public function __construct($raw_email)
    {
        $email = filter_var($raw_email, FILTER_VALIDATE_EMAIL);
        // The `Flamingo_Contact::search_by_email()` returns one of existing
        // contact when we searching with the empty email, so we need to check
        // this first.
        if (! $email)
            throw new \err\No_Contact($raw_email);

        $contact = Flamingo_Contact::search_by_email($email);
        if (! $contact)
            throw new \err\No_Contact($email);

        $this->id = $contact->id();
        $this->email = $contact->email;
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
        return contact\token\build($this);
    }

    public function tag_names()
    {
        $tags = wp_get_post_terms($this->id, self::TAG_TAXONOMY);
        return array_map(function($tag) {return $tag->name;}, $tags);
    }

    public function is_confirmed()
    {
        return in_array(self::TAG_CONFIRMED, $this->tag_names());
    }

    public function confirm()
    {
        wp_set_post_terms(
            $this->id,
            self::TAG_CONFIRMED,
            self::TAG_TAXONOMY,
            TRUE);
    }
}
