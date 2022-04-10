<?php namespace email\admin_notify;
// TODO: DRY with confirmation-email

require_once CORMORANT_DIR . 'core/contact/shortcodes/common.php';

const HEADERS = "Content-Type: text/html; charset=UTF-8\n";

function send($contact)
{
    $admin_email = get_option('admin_email');
    $subject = \settings\get('notify_email_subject');
    $body = body($contact);
    wp_mail($admin_email, $subject, $body, HEADERS);
}

function body($contact)
{
    $messages = $contact->related_messages();
    $last_message = (array) end($messages);
    $shortcodes = \shortcodes\common($last_message);
    $template = \settings\get('notify_email_template');
    return \shortcodes\replace($shortcodes, $template);
}
