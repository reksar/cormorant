<?php

require_once 'class-email.php';

class Admin_Notify_Email extends Email
{
    public function email()
    {
        return get_option('admin_email');
    }

    public function subject()
    {
        return \settings\get('notify_email_subject');
    }

    public function template()
    {
        return \settings\get('notify_email_template');
    }
}
