<?php

namespace RelayWP\LPoints\App;

defined('ABSPATH') or exit;

use RelayWP\LPoints\App\Setup;

class App extends Container
{

    public static $app;

    public static function make()
    {
        if (!isset(self::$app)) {
            self::$app = new static();
        }

        return self::$app;
    }

    /* Bootstrap plugin
     */
    public function bootstrap()
    {
        Setup::init();
        add_action('plugins_loaded', function () {
            do_action('wpr_loyalty_points_before_init');
            Route::register();

            do_action('wpr_loyalty_points_after_init');
        }, 1);
    }
}
