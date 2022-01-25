<?php

require_once 'interface-contact.php';

class Confirmation_Email
{
    const ACTION = 'confirm_email';
    const TOKEN_NAME = 'token';

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
        return 'Confirmation link: ' . $this->confirmation_link();
	}

    public function headers(): string
    {
        return "Content-Type: text/html; charset=UTF-8\n";
    }

    public function confirmation_link(): string
    {
        $action = self::ACTION;
        $token_name = self::TOKEN_NAME;
        $token = urlencode($this->token);
        $url_suffix = "admin-post.php?action=$action&$token_name=$token";

        $blog_id = NULL;
        $url = get_admin_url($blog_id, $url_suffix);

        return "<a target=\"_blank\" href=\"$url\">$url</a>";
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
