<?php namespace sanitize;

function email_template($value)
{
    return sanitize_text_field($value);
}
