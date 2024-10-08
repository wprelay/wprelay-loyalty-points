<?php

namespace RelayWP\LPoints\Src\Controllers\Admin;

use RelayWP\LPoints\App\Helpers\PluginHelper;
use RelayWP\LPoints\App\Helpers\WordpressHelper;
use RelayWP\LPoints\App\Services\View;

class PageController
{
    /*
     *
     * instead of return just use echo when returning page in word-press plugin
     */

    public static function show()
    {
        $existing_points = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $points = $_POST['points'] ?? [];

            $existing_points = get_option(WPR_LPOINTS_WP_OPTION_KEY, "{}");

            $existing_points = json_decode($existing_points, true);

            foreach ($points as $key => $value) {
                $existing_points[$key] = $value;
            }

            update_option(WPR_LPOINTS_WP_OPTION_KEY, json_encode($existing_points));
        }

        $existing_points = get_option(WPR_LPOINTS_WP_OPTION_KEY, "{}");

        $existing_points = json_decode($existing_points, true);

        $url = WordpressHelper::getCurrentURL();

        // Get the list of WooCommerce currencies
        $currencies = get_woocommerce_currencies();

        $code = get_woocommerce_currency();

        $label = $currencies[$code] ?? $code;

        $currencies = apply_filters('relaywp_currency_list_for_points_conversion', [$code => $label]);

        $list = [];

        foreach ($currencies as $code => $label) {
            $list[$code]['currency_code'] = $code;
            $list[$code]['label'] = $label;
            $list[$code]['points'] = $existing_points[$code] ?? 0;
        }

        echo View::render('admin', [
            'list' => $list,
            'url' => $url,
        ]);
    }

    public static function getPaginationData($data)
    {
        if (!isset($data['total']) || !isset($data['per_page']) || !isset($data['current_page'])) {
            return [];
        }

        $total_pages = $data['total_pages'];
        $current_page = $data['current_page'];
        $per_page = $data['per_page'];
        $total = $data['total'];

        $pages = [];

        foreach (range(1, $total_pages) as $index) {
            $link = static::addQueryParamInCurrentURL([
                'current_page' => $index,
                'per_page' => $per_page
            ]);
            $pages[] = ['index' => $index, 'link' => $link];
        }

        return [
            'show_pagination' => $per_page < $total,
            'pages' => $pages,
            'total_pages' => $total_pages,
            'total' => $total,
            'current_page' => $current_page,
            'per_page' => $data['per_page'],
            'previous_page' => ($current_page - 1) ? [
                'index' => $current_page - 1,
                'link' => static::addQueryParamInCurrentURL([
                    'current_page' => $current_page - 1,
                    'per_page' => $per_page
                ])
            ] : null,
            'next_page' => ($current_page) != $total_pages ? [
                'index' => $current_page + 1,
                'link' => static::addQueryParamInCurrentURL([
                    'current_page' => $current_page + 1,
                    'per_page' => $per_page
                ])
            ] : null,
        ];
    }

    public static function addQueryParamInCurrentURL($array)
    {

        $url = WordpressHelper::getCurrentURL();

        $parsedUrl = wp_parse_url($url);

        $queryParams = [];

        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);

            $queryParams = array_merge($queryParams, $array);
        }

        // Rebuild the query string
        return "{$parsedUrl['path']}?" . http_build_query($queryParams);
    }

    private static function getPaginationQueryParams()
    {
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $perPage = isset($_GET['per_page']) ? $_GET['per_page'] : 5;

        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $currentPage = isset($_GET['current_page']) ? $_GET['current_page'] : 1;

        return [$perPage, $currentPage];
    }
}
