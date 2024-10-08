<?php

namespace RelayWP\LPoints\App\Hooks;


class WPHooks extends RegisterHooks
{
    public static function register()
    {
        static::registerCoreHooks('wp-hooks.php');
    }
}
