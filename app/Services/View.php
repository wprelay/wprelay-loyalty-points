<?php

namespace RelayWP\LPoints\App\Services;

defined('ABSPATH') or exit;

use RelayWP\LPoints\App\App;
use RelayWP\LPoints\App\Helpers\Functions;

class View
{
    public static function instance()
    {
        return new static();
    }

    public static function render($path, $data = [])
    {
        return static::instance()->view($path, array_merge(['app' => App::make()], $data));
    }

    public function view($path, $data, $print = true)
    {
        $file = WPR_LPOINTS_PLUGIN_PATH . 'resources/' . $path . '.php';
        return Functions::renderTemplate($file, $data);
    }
}
