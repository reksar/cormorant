<?php namespace flamingo\contact\token;

require_once CORMORANT_DIR . 'core/contact/interface-contact.php';

const SEPARATOR = ':';

function from_contact(\Contact $contact): string
{
    $salt = (string) $contact->id();
    $payload = $contact->email() . SEPARATOR . $salt;
    return base64_encode($payload);
}

function email(string $token): string
{
    $payload = base64_decode($token);
    return explode(SEPARATOR, $payload)[0];
}

function id(string $token): int
{
    $payload = base64_decode($token);
    return (int) explode(SEPARATOR, $payload)[1];
}

function filter(string $token): ?string
{
    return filter_var($token, FILTER_VALIDATE_REGEXP, [
        // At least one (+) alphabet, number, + / = character.
        // @see https://www.rfc-editor.org/rfc/rfc4648#page-6
        'options' => ['regexp' => '/^[[:alnum:]\+\/=]+$/'],
    ]);
}
