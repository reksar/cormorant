<?php

require_once 'view/notice.php';

class Notice
{
    private $text;

    public function __construct($text)
    {
        $this->text = $text;
        add_action('admin_notices', $this);
    }

    public function __invoke()
    {
        view\notice($this->text);
    }
}
