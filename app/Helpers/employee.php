<?php
if (!function_exists('getFullNameAttribute')) {
    function getFullNameAttribute($model)
    {
        return "{$model->first_name} {$model->last_name}";
    }
}

if (! function_exists('generateEmployeeCode')) {
    function generateEmployeeCode()
    {
        return 'EMP-' . strtoupper(uniqid());
    }
}
