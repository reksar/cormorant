<?php namespace err;

class Bad_Token extends \Exception
{
    public function __construct(?string $token)
    {
        $token = $token ?: 'empty token';

        $message = "Bad email confirmation token: $token";

        parent::__construct($message);
    }
} 
