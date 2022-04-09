<?php namespace contact\token;

require_once CORMORANT_DIR . 'core/err/class-bad-token.php';

// The token is base64 encoded payload string.
// The payload is "<email><SEPARATOR><id>".
const SEPARATOR = ':';
// When payload is exploded by `SEPARATOR`,
// it must be an array[PARTS] - <email> and <id>:
const PARTS = 2;
const EMAIL_PART = 0;
const ID_PART = 1;

function from_contact($contact)
{
    $payload = $contact->email() . SEPARATOR . $contact->id();
    return base64_encode($payload);
}

function email($token)
{
    return filter_var(part($token, EMAIL_PART), FILTER_VALIDATE_EMAIL);
}

function id($token)
{
    return filter_var(part($token, ID_PART), FILTER_VALIDATE_INT);
}

function filter($token)
{
    return filter_var($token, FILTER_VALIDATE_REGEXP, [
        // Alphabet, number or + / =
        // See https://www.rfc-editor.org/rfc/rfc4648#page-6
        'options' => ['regexp' => '/^[[:alnum:]\+\/=]+$/'],
    ]);
}

function part($token, $idx)
{
    $payload = base64_decode($token);
    $parts = explode(SEPARATOR, $payload);

    if (count($parts) != PARTS)
        throw new \err\Bad_Token($token);

    return $parts[$idx];
}
