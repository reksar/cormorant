<?php namespace sanitize;

function email_subject($value)
{
    return sanitize_text_field($value);
}
