<?php namespace contact\confirmation_email;
// TODO: DRY with admin-notify-email

// TODO: avoid circular requirements.
require_once CORMORANT_DIR . 'core/actions/get-confirmation.php';

const LINK_SHORTCODE = '[confirmation-link]';
const HEADERS = "Content-Type: text/html; charset=UTF-8\n";

function send($contact)
{
    $email = $contact->email();
    $body = body($contact->token());
    $subject = \settings\get('email_subject');
    // TODO: check status
    wp_mail($email, $subject, $body, HEADERS);
}

function body($token)
{
    $link = confirmation_link($token);
    $template = \settings\get('email_template') ?: LINK_SHORTCODE;
    return str_replace(LINK_SHORTCODE, $link, $template);
}

function confirmation_link($token)
{
    $action = \action\get_confirmation\WP_ACTION;
    $token_name = \action\get_confirmation\TOKEN_URL_PARAM;
    $token_value = urlencode($token);
    $url_tail = "admin-post.php?action=$action&$token_name=$token_value";

    $blog_id = NULL; // Current blog
    $url = get_admin_url($blog_id, $url_tail);

    return "<a target=\"_blank\" href=\"$url\">$url</a>";
}
