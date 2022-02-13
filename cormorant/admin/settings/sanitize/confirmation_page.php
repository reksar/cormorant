<?php namespace sanitize;

function confirmation_page($value)
{
    return sanitize_text_field($value);
}
