<?php namespace sanitize;

function confirmed_tag($value)
{
    return filter_var(sanitize_text_field($value), FILTER_VALIDATE_REGEXP, [
        // Alphabet, number or -
        'options' => ['regexp' => '/^[[:alnum:]-]+$/'],
    ]);
}
