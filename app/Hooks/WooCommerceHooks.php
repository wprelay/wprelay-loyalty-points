<?php

namespace RelayWP\LPoints\App\Hooks;

class WooCommerceHooks extends RegisterHooks
{
    public static function register()
    {
        static::registerCoreHooks('woocommerce-hooks.php');
    }
}
