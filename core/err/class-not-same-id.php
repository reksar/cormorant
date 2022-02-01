<?php namespace err;

class Not_Same_Id extends \Exception
{
    public function __construct($contact_id, $token_id)
    {
        $message = "The Flamingo contact was found with the email from " .
            "token, but the token id $token_id is differs from the original " .
            "contact id $contact_id.";

        parent::__construct($message);
    }
} 
