<?php
if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        return config('settings.' . $key, $default);
    }
}
