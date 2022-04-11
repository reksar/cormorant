<?php

require_once CORMORANT_DIR . 'core/contact/shortcodes/common.php';

abstract class Email
{
    const HEADERS = "Content-Type: text/html; charset=UTF-8\n";

    protected $contact;

    abstract public function email();
    abstract public function subject();
    abstract public function template();

    public function __construct($contact)
    {
        $this->contact = $contact;
    }

    public function send()
    {
        $body = \shortcodes\replace($this->shortcodes(), $this->template());
        wp_mail($this->email(), $this->subject(), $body, self::HEADERS);
    }

    public function shortcodes()
    {
        $messages = $this->contact->related_messages();
        $last_message = (array) end($messages);
        return \shortcodes\common($last_message);
    }
}
