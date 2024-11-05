<?php

namespace RelayWP\LPoints\App;

defined('ABSPATH') or exit;

use RelayWP\LPoints\App\Hooks\AdminHooks;
use RelayWP\LPoints\App\Hooks\CustomHooks;
use RelayWP\LPoints\App\Hooks\WPHooks;

class Route
{
    //declare the below constants with unique reference for your plugin
    const AJAX_NAME = 'wp_relay_lpoints';
    const AJAX_NO_PRIV_NAME = 'wprelay_lpoints_guest_apis';

    public static function register()
    {
        AdminHooks::register();
        // AssetsActions::register();
        CustomHooks::register();
        WPHooks::register();
    }
}
