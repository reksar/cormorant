<?php namespace shortcodes;

require_once CORMORANT_DIR . 'core/actions/interface.php';

const CONFIRMATION_LINK = '[confirmation-link]';
const BLOG_ID = NULL; // Current blog.

function confirmation_link($token)
{
    return [CONFIRMATION_LINK => confirmation_link_html($token)];
}

function confirmation_link_html($token)
{
    $url = confirmation_link_url($token);
    return "<a target=\"_blank\" href=\"$url\">$url</a>";
}

function confirmation_link_url($token)
{
    return get_admin_url(BLOG_ID, confirmation_link_tail($token));
}

function confirmation_link_tail($token)
{
    $action = \actions\WP_ACTION;
    $token_name = \actions\TOKEN_URL_PARAM;
    $token_value = urlencode($token);
    return "admin-post.php?action=$action&$token_name=$token_value";
}
