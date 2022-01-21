<?php

require_once 'interface-contact.php';

class Confirmation_Email
{
    private string $email;
    private string $token;

    public function __construct(Contact $contact)
    {
        $this->email = $contact->email();
        $this->token = $contact->token();
    }

    public function email(): string
    {
        return $this->email;
    }

    public function subject(): string
    {
        return 'Test subject';
    }

    private function body(): string
    {
        return 'Test message, confirmation token: ' . $this->token;
	}

    public function headers(): string
    {
        return "Content-Type: text/html; charset=UTF-8\n";
    }

    public function send()
    {
        wp_mail(
            $this->email(),
            $this->subject(),
            $this->body(),
            $this->headers());
    }
}
