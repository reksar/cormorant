<?php

require_once 'class-email.php';

require_once CORMORANT_DIR . 'core/contact/shortcodes/confirmation-link.php';
use const \shortcodes\CONFIRMATION_LINK;

class Confirmation_Email extends Email
{
    public function email()
    {
        return $this->contact()->email();
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
        $token = $this->contact()->token();
        $link_shortcode = \shortcodes\confirmation_link($token);
        return array_merge(parent::shortcodes(), $link_shortcode);
    }

    public function contact()
    {
        return $this->data['contact_instance'];
    }
}
