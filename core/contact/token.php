<?php namespace contact\token;

require_once CORMORANT_DIR . 'core/err/class-bad-token.php';

const SEPARATOR = ':';

function from_contact($contact)
{
    $payload = $contact->email() . SEPARATOR . $contact->id();
    return base64_encode($payload);
}

// TODO: validate
function email($token)
{
    $payload = base64_decode($token);
    return explode(SEPARATOR, $payload)[0];
}

// TODO: validate
function id($token)
{
    $payload = base64_decode($token);
    return (int) explode(SEPARATOR, $payload)[1];
}

function filter($token)
{
    return filter_var($token, FILTER_VALIDATE_REGEXP, [
        // At least one alphabet, number or + / =
        // @see https://www.rfc-editor.org/rfc/rfc4648#page-6
        'options' => ['regexp' => '/^[[:alnum:]\+\/=]+$/'],
    ]);
}
