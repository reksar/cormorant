<?php

require_once 'class-email.php';

require_once 'shortcodes/confirmation-link.php';
use const \shortcodes\CONFIRMATION_LINK;

class Confirmation_Email extends Email
{
    public function __construct(array $data, $contact)
    {
        parent::__construct(array_merge($data, [
            'contact' => [
                'email' => $contact->email(),
                'token' => $contact->token(),
            ],
        ]));
    }

    public function email()
    {
        return $this->data['contact']['email'];
    }

    public function subject()
    {
        return \settings\get('email_subject');
    }

    public function template()
    {
        return \settings\get('email_template') ?: CONFIRMATION_LINK;
    }

    public function shortcodes()
    {
        $token = $this->data['contact']['token'];
        $link_shortcode = \shortcodes\confirmation_link($token);
        return array_merge(parent::shortcodes(), $link_shortcode);
    }
}
