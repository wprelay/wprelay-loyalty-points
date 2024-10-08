<?php

namespace RelayWP\LPoints\App\Services;

use RelayWP\LPoints\App\Helpers\Functions;

class Settings
{
    private static $settings = [];

    public static function get($key, $default = null)
    {
        if (empty(static::$settings)) {
            static::$settings = static::fetchSettings();
        }

        return Functions::dataGet(static::$settings, $key, $default);
    }

    public static function fetchSettings()
    {
        $wpr_settings = get_option('wpr_lpoints_settings', '[]');

        return json_decode($wpr_settings, true);
    }
}
