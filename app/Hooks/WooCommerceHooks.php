<?php

namespace RelayWP\LPoints\App\Hooks;

defined('ABSPATH') or exit;

class WooCommerceHooks extends RegisterHooks
{
    public static function register()
    {
        static::registerCoreHooks('woocommerce-hooks.php');
    }
}
