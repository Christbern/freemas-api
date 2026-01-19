<?php

if (! function_exists('isEmail')) {
    function isEmail($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }
}

if (! function_exists('isPhone')) {
    function isPhone($value)
    {
        return preg_match('/^[0-9]{8,15}$/', $value);
    }
}

if (! function_exists('humanDate')) {
    function humanDate($date)
    {
        return \Carbon\Carbon::parse($date)->translatedFormat('d F Y');
    }
}
