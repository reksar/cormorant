<?php namespace sanitize;

function notify_admin_on_confirmation($value)
{
    return (int) (bool) $value;
}
