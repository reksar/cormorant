<?php namespace flamingo\contact;

require_once CORMORANT_DIR . 'core/contact/interface-contact.php';
require_once 'class-contact.php';
require_once 'token.php';
require_once 'err/class-no-contact.php';
require_once 'err/class-different-token-id.php';

use \flamingo\contact\token as token;

function by_email(string $email): \Contact
{
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    // Flamingo can give us one of existing contacts even we searching by 
    // empty email, so we must check this first.
    if ($email) {
        // Will be the `Flamingo_Contact` instance or `NULL`.
        $contact = \Flamingo_Contact::search_by_email($email);
        if ($contact) return new \flamingo\Contact($contact);
    }
    throw new \err\No_Contact($email);
}

function by_token(string $token): \Contact
{
    $email = token\email($token);
    $contact = by_email($email);

    $contact_id = $contact->id();
    $token_id = token\id($token);
    if ($contact_id === $token_id) return $contact;

    throw new \err\Different_Token_Id($token_id, $contact_id);
}
