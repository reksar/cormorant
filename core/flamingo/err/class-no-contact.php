<?php namespace err;

class No_Contact extends \Exception
{
    public function __construct(string $email)
    {
        $email = $email ?: 'empty email';

        $message = "Flamingo can't find a contact with the $email. Probably " .
            "form has been submitted correctly, but some errors happens " .
            "later.";

        parent::__construct($message);
    }
} 
