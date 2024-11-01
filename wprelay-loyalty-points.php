<?php


/**
 * Plugin Name:          RelayWP Points 
 * Description:          Payouts Using WPLoyalty for RelayWP
 * Version:              1.0.0
 * Requires at least:    5.9
 * Requires PHP:         7.3
 * Author:               RelayWP * Author URI:           https://www.wprelay.com
 * Text Domain:          flycart.org
 * Domain Path:          /i18n/languages
 * License:              GPL v3 or later
 * License URI:          https://www.gnu.org/licenses/gpl-3.0.html
 * WC requires at least: 7.0
 * WC tested up to:      8.1
 * Relay:              1.0.5
 * Relay Page Link:    wprelay-loyalty-points
 */

defined('ABSPATH') or exit;

defined('WPR_LPOINTS_PLUGIN_PATH') or define('WPR_LPOINTS_PLUGIN_PATH', plugin_dir_path(__FILE__));
defined('WPR_LPOINTS_PLUGIN_URL') or define('WPR_LPOINTS_PLUGIN_URL', plugin_dir_url(__FILE__));
defined('WPR_LPOINTS_PLUGIN_FILE') or define('WPR_LPOINTS_PLUGIN_FILE', __FILE__);
defined('WPR_LPOINTS_PLUGIN_NAME') or define('WPR_LPOINTS_PLUGIN_NAME', "RelayWP-Loyalty-Points");
defined('WPR_LPOINTS_PLUGIN_SLUG') or define('WPR_LPOINTS_PLUGIN_SLUG', "wprelay-loyalty-points");
defined('WPR_LPOINTS_VERSION') or define('WPR_LPOINTS_VERSION', "1.0.0");
defined('WPR_LPOINTS_PREFIX') or define('WPR_LPOINTS_PREFIX', "prefix_");
defined('WPR_LPOINTS_MAIN_PAGE') or define('WPR_LPOINTS_MAIN_PAGE', "wprelay-loyalty-points");
defined('WPR_LPOINTS_WP_OPTION_KEY') or define('WPR_LPOINTS_WP_OPTION_KEY', "relaywp_lpoints_conversion");

/**
 * Required PHP Version
 */
if (!defined('WPR_LPOINTS_REQUIRED_PHP_VERSION')) {
    define('WPR_LPOINTS_REQUIRED_PHP_VERSION', 7.2);
}

if (file_exists(WPR_LPOINTS_PLUGIN_PATH . '/vendor/autoload.php')) {
    require WPR_LPOINTS_PLUGIN_PATH . '/vendor/autoload.php';
} else {
    error_log('Vendor directory is not found');
    return;
}

if (defined('WC_VERSION')) {
    /**
     * To set plugin is compatible for WC Custom Order Table (HPOS) feature.
     */
    add_action('before_woocommerce_init', function () {
        if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
            \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
        }
    });
}


if (!function_exists('wpr_check_is_wp_relay_installed')) {
    function wpr_check_is_wp_relay_installed()
    {
        $plugin_path = trailingslashit(WP_PLUGIN_DIR) . 'wprelay-pro/wprelay-pro.php';

        $pro_installed = in_array($plugin_path, wp_get_active_and_valid_plugins())
            || (is_multisite() && in_array($plugin_path, wp_get_active_network_plugins()));

        $plugin_path = trailingslashit(WP_PLUGIN_DIR) . 'relaywp/relaywp.php';

        $core_installed = in_array($plugin_path, wp_get_active_and_valid_plugins())
            || (is_multisite() && in_array($plugin_path, wp_get_active_network_plugins()));

        return $core_installed || $pro_installed;
    }
}

if (function_exists('wpr_check_is_wp_relay_installed')) {
    if (!wpr_check_is_wp_relay_installed()) {

        $class = 'notice notice-warning';
        $name = WPR_LPOINTS_PLUGIN_NAME;
        $status = 'warning';
        $message = __("Error you did not installed the RelayWP Plugin to work with {$name}", 'text-domain');
        add_action('admin_notices', function () use ($message, $status) {
?>
            <div class="notice notice-<?php echo esc_attr($status); ?>">
                <p><?php echo wp_kses_post($message); ?></p>
            </div>
        <?php
        }, 1);
        return;
    }
}

//Loading woo-commerce action schedular
require_once(plugin_dir_path(__FILE__) . '../woocommerce/packages/action-scheduler/action-scheduler.php');

if (class_exists('RelayWP\LPoints\App\App')) {
    //If the Directory Exists it means it's a pro pack;
    //Check Whether it is PRO USER

    $app = \RelayWP\LPoints\App\App::make();

    $app->bootstrap(); // to load the plugin

} else {
    //    wp_die('Plugin is unable to find the App class.');
    return;
}

/**
 * To set plugin is compatible for WC Custom Order Table (HPOS) feature.
 */
add_action('before_woocommerce_init', function () {
    if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
    }
});

add_action('admin_head', function () {
    $page = !empty($_GET['page']) ? $_GET['page'] : '';
    $main_page_name = WPR_LPOINTS_MAIN_PAGE;
    if (in_array($page, array($main_page_name))) {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                self = window;
            });
        </script>
<?php
    }
}, 11);


add_action('wpr_loyalty_points_after_init', function () {
    if (class_exists('Puc_v4_Factory')) {
        $myUpdateChecker = \Puc_v4_Factory::buildUpdateChecker(
            'https://github.com/wprelay/wployalty-points-integration',
            __FILE__,
            'wprelay-loyalty-points'
        );
        $myUpdateChecker->getVcsApi()->enableReleaseAssets();
    }
});
