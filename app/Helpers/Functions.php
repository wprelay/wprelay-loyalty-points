<?php

namespace RelayWP\LPoints\App\Helpers;

defined('ABSPATH') or exit;

use DateTime;
use DateTimeZone;

class Functions
{
    //code

    public static function renderTemplate($file, $data = [])
    {
        if (file_exists($file)) {
            ob_start();
            extract($data);
            include $file;
            return ob_get_clean();
        }
        return false;
    }

    public static function utcToWPTime($datetime, $format = 'Y-m-d H:i:s')
    {
        if (empty($datetime)) return null;

        $date = new DateTime($datetime, new DateTimeZone('UTC'));

        $timestamp = $date->format('U');

        return wp_date($format, $timestamp);
    }

    public static function getWcTime($datetime, $format = 'Y-m-d H:i:s')
    {
        return static::utcToWPTime($datetime, $format);
    }

    public static function currentUTCTime($format = 'Y-m-d H:i:s')
    {
        return current_datetime()->setTimezone(new DateTimeZone('UTC'))->format($format);
    }

    public static function dataGet(array $array, string $key, $default = null)
    {
        $keys = explode('.', $key);

        foreach ($keys as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return $default;
            }

            $array = $array[$segment];
        }

        return $array;
    }

    public static function getUniqueId($length = 12)
    {
        return substr(md5(uniqid(mt_rand(), true)), 0, $length);
    }
}
