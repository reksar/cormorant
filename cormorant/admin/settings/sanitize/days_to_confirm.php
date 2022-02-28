<?php namespace sanitize;

function days_to_confirm($value)
{
    $days = (int) $value;
    $max_days = \settings\field('days_to_confirm')['max'];
    return (0 <= $days && $days <= $max_days) ? $days : 0;
}
