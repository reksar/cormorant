<?php namespace contact\token;

const SEPARATOR = ':';

function build($contact)
{
    $payload = $contact->email() . SEPARATOR . $contact->id();
    return base64_encode($payload);
}

function email($token)
{
    $payload = base64_decode($token);
    return explode(SEPARATOR, $payload)[0];
}

function id($token)
{
    $payload = base64_decode($token);
    return (int) explode(SEPARATOR, $payload)[1];
}

function filter($token)
{
    return filter_var($token, FILTER_VALIDATE_REGEXP, [
        // At least one (+) alphabet, number, + / = character.
        // @see https://www.rfc-editor.org/rfc/rfc4648#page-6
        'options' => ['regexp' => '/^[[:alnum:]\+\/=]+$/'],
    ]);
}
