<?php namespace email;

require_once 'class-confirmation-email.php';
require_once 'class-admin-notify-email.php';

function confirmation($contact, array $form_data)
{
    $data = array_merge($form_data, [
        'contact_instance' => $contact
    ]);
    (new \Confirmation_Email($data))->send();
}

function admin_notify(array $last_contact_message)
{
    (new \Admin_Notify_Email($last_contact_message))->send();
}
