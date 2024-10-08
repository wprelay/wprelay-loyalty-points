<?php

namespace RelayWP\LPoints\App\Hooks;

use RelayWP\LPoints\App\Helpers\AssetHelper;
use RelayWP\LPoints\App\Helpers\WordpressHelper;
use RelayWP\LPoints\App\Services\Settings;

defined('ABSPATH') or exit;

class AssetsActions
{
    public static function register()
    {
        static::enqueue();
    }

    /**
     * Enqueue scripts
     */
    public static function enqueue()
    {
        // add_action('admin_enqueue_scripts', [__CLASS__, 'addAdminPluginAssets']);
        // add_action('wp_enqueue_scripts', [__CLASS__, 'addStoreFrontScripts']);
    }

    public static function addAdminPluginAssets($hook)
    {
        //code
    }

    public static function addStoreFrontScripts()
    {
        //code
    }

    public static function getStoreConfigValues()
    {
        //code
    }
}
