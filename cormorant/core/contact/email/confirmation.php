<?php namespace email\confirmation;
// TODO: DRY with admin-notify-email

require_once CORMORANT_DIR . 'core/contact/shortcodes/common.php';
require_once CORMORANT_DIR . 'core/contact/shortcodes/confirmation-link.php';
use const \shortcodes\CONFIRMATION_LINK;

const HEADERS = "Content-Type: text/html; charset=UTF-8\n";

function send($contact)
{
    $email = $contact->email();
    $subject = \settings\get('email_subject');
    $body = body($contact);
    wp_mail($email, $subject, $body, HEADERS);
}

function body($contact)
{
    // TODO: do not use if empty email template setting.
    $messages = $contact->related_messages();
    $last_message = (array) end($messages);
    $common_shortcodes = \shortcodes\common($last_message);

    $token = $contact->token();
    $link_shortcode = \shortcodes\confirmation_link($token);

    $shortcodes = array_merge($common_shortcodes, $link_shortcode);

    $template = \settings\get('email_template') ?: CONFIRMATION_LINK;
    return \shortcodes\replace($shortcodes, $template);
}
