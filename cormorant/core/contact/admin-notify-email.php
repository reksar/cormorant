<?php namespace contact\admin_notify_email;
// TODO: DRY with confirmation-email

const HEADERS = "Content-Type: text/html; charset=UTF-8\n";
const EMAIL_SHORTCODE = '[email]';

function send($contact)
{
    $admin_email = get_option('admin_email');
    $subject = \settings\get('notify_email_subject');
    $body = body($contact);
    // TODO: check status
    wp_mail($admin_email, $subject, $body, HEADERS);
}

// TODO: more shortcodes from CF7.
function body($contact)
{
    $template = \settings\get('notify_email_template') ?: EMAIL_SHORTCODE;
    $email = $contact->email();
    return str_replace(EMAIL_SHORTCODE , $email, $template);
}
