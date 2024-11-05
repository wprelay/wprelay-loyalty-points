<?php

namespace RelayWP\LPoints\App\Hooks;

defined('ABSPATH') or exit;


class WPHooks extends RegisterHooks
{
    public static function register()
    {
        static::registerCoreHooks('wp-hooks.php');
    }
}
