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
    const TAG_TAXONOMY = \Flamingo_Contact::contact_tag_taxonomy;
    const TAG_CONFIRMED = 'confirmed';

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

    public function tag_names(): array
    {
		$tags = wp_get_post_terms($this->id(), self::TAG_TAXONOMY);
        return array_map(function($tag) {return $tag->name;}, $tags);
    }

    public function is_confirmed(): bool
    {
        return in_array(self::TAG_CONFIRMED, $this->tag_names());
    }

    public function confirm()
    {
        wp_set_post_terms(
            $this->id(),
            self::TAG_CONFIRMED,
            self::TAG_TAXONOMY,
            true);
    }
}
