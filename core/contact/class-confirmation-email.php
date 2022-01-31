<?php

require_once 'interface-contact.php';

class Confirmation_Email
{
    const ACTION = 'confirm_email';
    const TOKEN_URL_PARAM = 'token';
    const LINK_SHORTCODE = '[confirmation-link]';

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
        $settings = get_option('cormorant_settings');
        return $settings['email_subject'] ?? '';
    }

    private function body(): string
    {
        $settings = get_option('cormorant_settings');
        $template = $settings['email_template'] ?? self::LINK_SHORTCODE;
        $link = $this->confirmation_link();
        $link_shortcode = self::LINK_SHORTCODE;
        return str_replace($link_shortcode, $link, $template);
    }

    public function headers(): string
    {
        return "Content-Type: text/html; charset=UTF-8\n";
    }

    public function confirmation_link(): string
    {
        $action = self::ACTION;
        $token_name = self::TOKEN_URL_PARAM;
        $token = urlencode($this->token);
        $url_tail = "admin-post.php?action=$action&$token_name=$token";

        $blog_id = NULL; // Current blog
        $url = get_admin_url($blog_id, $url_tail);

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
