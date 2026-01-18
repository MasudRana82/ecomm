<?php

use App\Models\SiteSetting;

if (!function_exists('site_setting')) {
    /**
     * Get a site setting value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function site_setting($key, $default = null)
    {
        return SiteSetting::get($key, $default);
    }
}

if (!function_exists('site_logo')) {
    /**
     * Get the site logo URL
     *
     * @return string
     */
    function site_logo()
    {
        return asset(site_setting('site_logo', 'storage/logo/logo.png'));
    }
}
