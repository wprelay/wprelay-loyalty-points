<?php

use RelayWP\LPoints\Src\LPoints;

$store_front_hooks = [
    'actions' => [
        'wpr_process_lpoints_payouts' => ['callable' => [LPoints::class, 'sendPayments'], 'priority' => 11, 'accepted_args' => 1],
    ],
    'filters' => [
        'rwpa_payment_process_sources' => ['callable' => [LPoints::class, 'addPayment'], 'priority' => 11, 'accepted_args' => 4],
    ]
];

$admin_hooks = [
    'actions' => [],
    'filters' => []
];

return [
    'store_front_hooks' => $store_front_hooks,
    'admin_hooks' => $admin_hooks
];
