<?php

namespace RelayWP\LPoints\App\Hooks;

defined('ABSPATH') or exit;


class CustomHooks extends RegisterHooks
{
    public static function register()
    {
        static::registerCoreHooks('custom-hooks.php');
    }
}
