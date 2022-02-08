<?php namespace err;

class No_Contact extends \Exception
{
    public function __construct($email)
    {
        $email = $email ?: 'empty email';

        $message = "[Cormorant] Can't find a Flamingo contact by the $email.";

        parent::__construct($message);
    }
} 
