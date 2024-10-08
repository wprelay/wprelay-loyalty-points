<?php

namespace RelayWP\LPoints\App\Hooks;


class CustomHooks extends RegisterHooks
{
    public static function register()
    {
        static::registerCoreHooks('custom-hooks.php');
    }
}
