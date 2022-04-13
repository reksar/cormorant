<?php namespace sanitize;

function confirmed_tag($value)
{
    $tag = filter_var(sanitize_text_field($value), FILTER_VALIDATE_REGEXP, [
        // Alphabet, number or -
        'options' => ['regexp' => '/^[[:alnum:]-]+$/'],
    ]);

    // This WP function exists when settings are submitted.
    $add_err = '\add_settings_error';
    if (! $tag && function_exists($add_err))
        $add_err(\settings\NAME, 'confirmed_tag',
            __('Revert setting: Cormorant -> Confirmed tag.'));

    return $tag;
}
