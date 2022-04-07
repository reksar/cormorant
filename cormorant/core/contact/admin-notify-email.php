<?php namespace contact\admin_notify_email;
// TODO: DRY with confirmation-email

const HEADERS = "Content-Type: text/html; charset=UTF-8\n";
const EMAIL_SHORTCODE = '[email]';

// Available shortcodes based on these keys: "[_<key>]".
// See `replace_meta_shortcodes()`.
const META_KEYS = [
    'date',
    'time',
    'remote_ip',
];

function send($contact)
{
    $admin_email = get_option('admin_email');
    $subject = \settings\get('notify_email_subject');
    $body = body($contact);
    // TODO: check status
    wp_mail($admin_email, $subject, $body, HEADERS);
}

// TODO: more shortcodes from CF7.
// TODO: date/time format.
function body($contact)
{
    $template = \settings\get('notify_email_template') ?: EMAIL_SHORTCODE;

    $messages = $contact->related_messages();
    $last_message = end($messages);
    $message_meta = $last_message->meta;
    $text = replace_meta_shortcodes($template, $message_meta);

    $email = $contact->email();
    return str_replace(EMAIL_SHORTCODE, $email, $text);
}

function replace_meta_shortcodes($template, $message_meta)
{
    $meta = array_intersect_key($message_meta, array_flip(META_KEYS));

    return array_reduce(array_keys($meta),

        function($text, $key) use ($meta) {
            $shortcode = "[_$key]";
            $value = $meta[$key];
            return str_replace($shortcode, $value, $text);
        },

        $template);
}
