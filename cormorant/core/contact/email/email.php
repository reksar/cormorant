<?php namespace email;

require_once 'class-confirmation-email.php';
require_once 'class-admin-notify-email.php';

function confirmation($contact)
{
    (new \Confirmation_Email($contact))->send();
}

function admin_notify($contact)
{
    (new \Admin_Notify_Email($contact))->send();
}
