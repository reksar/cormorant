<?php namespace sanitize;

function notify_email_subject($value)
{
    return sanitize_text_field($value);
}
