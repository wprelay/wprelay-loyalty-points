<?php

defined('ABSPATH') or exit;

$store_front_hooks = [
    'actions' => [
        //        add_action( 'rest_api_init', 'wk_register_custom_routes' );
    ],
    'filters' => [],
];

$admin_hooks = [
    'actions' => [],
    'filters' => [],
];

return [
    'store_front_hooks' => $store_front_hooks,
    'admin_hooks' => $admin_hooks
];
