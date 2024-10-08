<?php

namespace RelayWP\LPoints\App\Hooks;

use RelayWP\LPoints\Src\Controllers\Admin\PageController;


class AdminHooks extends RegisterHooks
{
    public static function register()
    {
        static::registerCoreHooks('admin-hooks.php');
    }

    public static function init() {}

    public static function head() {}

    public static function addMenu()
    {
        add_submenu_page(
            '',
            WPR_LPOINTS_PLUGIN_NAME,
            WPR_LPOINTS_PLUGIN_NAME,
            'manage_options',
            'wprelay-loyalty-points',
            [PageController::class, 'show'],
            100
        );
    }
}
