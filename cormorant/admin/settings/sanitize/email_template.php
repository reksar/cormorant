<?php namespace sanitize;

function email_template($value)
{
    return sanitize_textarea_field($value);
}
