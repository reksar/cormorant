<?php namespace sanitize;

function days_to_confirm($value)
{
    // TODO: unite with view.
    $max_days = 365; // year
    $days = (int) $value;
    return (0 <= $days && $days <= $max_days) ? $days : 0;
}
