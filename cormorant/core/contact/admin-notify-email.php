<?php namespace contact\admin_notify_email;
// TODO: DRY with confirmation-email

const HEADERS = "Content-Type: text/html; charset=UTF-8\n";

// Fields of a `Flamingo_Inbound_Message` object.
const COMMON_KEYS = [
    'from_email',
    'from_name',
    'subject',
];

// Keys of a `Flamingo_Inbound_Message Object->meta` array.
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

function body($contact)
{
    $messages = $contact->related_messages();
    $last_message = (array) end($messages);
    $shortcodes_values = all_shortcodes($last_message);
    $replacements = dict_to_pairs($shortcodes_values);
    $replace = __NAMESPACE__ . '\replace_shortcode';
    $template = \settings\get('notify_email_template');
    return array_reduce($replacements, $replace, $template);
}

function all_shortcodes($message)
{
    return array_merge(
        common_shortcodes($message),
        meta_shortcodes($message),
        field_shortcodes($message));
}

function common_shortcodes($message)
{
    $values = array_intersect_key($message, array_flip(COMMON_KEYS));
    return shortcodes_values(__NAMESPACE__ . '\shortcode', $values);
}

function meta_shortcodes($message)
{
    $values = array_intersect_key($message['meta'], array_flip(META_KEYS));
    return shortcodes_values(__NAMESPACE__ . '\meta_shortcode', $values);
}

function field_shortcodes($message)
{
    $values = array_filter($message['fields'], 'is_scalar');
    return shortcodes_values(__NAMESPACE__ . '\shortcode', $values);
}

function shortcodes_values($shortcode_builder, $values)
{
    $keys = array_keys($values);
    $shortcodes = array_map($shortcode_builder, $keys);
    return array_combine($shortcodes, $values);
}

function replace_shortcode($template, $pair)
{
    list($shortcode, $value) = $pair;
    return str_replace($shortcode, $value, $template);
}

function dict_to_pairs($dict)
{
    return array_map(__NAMESPACE__ . '\pair', array_keys($dict), $dict);
}

function pair($x, $y)
{
    return [$x, $y];
}

function shortcode($key)
{
    return "[$key]";
}

function meta_shortcode($key)
{
    return "[_$key]";
}
