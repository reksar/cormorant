<?php namespace email;

require_once 'class-confirmation-email.php';
require_once 'class-admin-notify-email.php';

function confirmation($contact, array $form_data)
{
    (new \Confirmation_Email($form_data, $contact))->send();
}

function admin_notify(array $last_contact_message)
{
    (new \Admin_Notify_Email($last_contact_message))->send();
}
