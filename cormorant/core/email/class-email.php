<?php

require_once 'shortcodes/common.php';

abstract class Email
{
    const HEADERS = "Content-Type: text/html; charset=UTF-8\n";

    // To fill the email, e.g. to replace shortcodes.
    protected array $data;

    abstract public function email();
    abstract public function subject();
    abstract public function template();

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function send()
    {
        $body = \shortcodes\replace($this->shortcodes(), $this->template());
        wp_mail($this->email(), $this->subject(), $body, self::HEADERS);
    }

    public function shortcodes()
    {
        return \shortcodes\common($this->data);
    }
}
