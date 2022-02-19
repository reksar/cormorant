<?php namespace err;

class Bad_Token extends \Exception
{
    public function __construct($token)
    {
        $token = $token ?: 'empty token';

        $message = "[Cormorant] Bad contact confirmation token: $token";

        parent::__construct($message);
    }
} 
