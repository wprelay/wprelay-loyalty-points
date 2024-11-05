<?php

namespace RelayWP\LPoints\App;

defined('ABSPATH') or exit;

use RelayWP\LPoints\Src\Models\Model;

class Setup
{
    /**
     * Init setup
     */
    public static function init()
    {
        register_activation_hook(WPR_LPOINTS_PLUGIN_FILE, [__CLASS__, 'activate']);
        register_deactivation_hook(WPR_LPOINTS_PLUGIN_FILE, [__CLASS__, 'deactivate']);
        register_uninstall_hook(WPR_LPOINTS_PLUGIN_FILE, [__CLASS__, 'uninstall']);

        add_action('plugins_loaded', [__CLASS__, 'maybeRunMigration']);
    }

    /**
     * Run plugin activation scripts
     */
    public static function activate()
    {
        //code
    }

    /**
     * Run plugin activation scripts
     */
    public static function deactivate()
    {
        //        wp_clear_scheduled_hook('rwp_update_affiliate_coupons');
    }

    /**
     * Run plugin activation scripts
     */
    public static function uninstall() {}

    /**
     * Maybe run database migration
     */
    public static function maybeRunMigration()
    {
        $current_version = get_option('wpr_lpoints_current_version', 0);

        if (version_compare(WPR_LPOINTS_VERSION, $current_version) > 0) {
            if (!is_admin()) {
                return;
            }

            static::runMigration();
            update_option('wpr_lpoints_current_version', WPR_LPOINTS_VERSION);
        }
    }

    /**
     * Run database migration
     */
    private static function runMigration()
    {
        // $models = static::getModels();
        //
        // foreach ($models as $model) {
        //     $object = (new $model);
        //
        //     if ($object instanceof Model) {
        //         $query = $object->createTable();
        //         $object->executeDatabaseQuery($query);
        //     }
        // }
    }

    /**
     * @return string[]
     */
    public static function getModels(): array
    {
        return [];
    }
}
