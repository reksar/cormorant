<?php namespace err;

class Different_Token_Id extends \Exception
{
    public function __construct(string $token_id, string $contact_id)
    {
        $message = "The Flamingo contact was found with the email from " .
            "token, but the token id $token_id is differs from the original " .
            "contact id $contact_id.";

        parent::__construct($message);
    }
} 
