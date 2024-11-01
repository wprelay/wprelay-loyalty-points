<?php

namespace RelayWP\LPoints\Src;

use RelayWp\Affiliate\Core\Models\Affiliate;
use RelayWp\Affiliate\Core\Models\Member;
use RelayWp\Affiliate\Core\Payments\RWPPayment;
use RelayWp\Affiliate\Core\Models\Payout;
use RelayWP\LPoints\App\Helpers\PluginHelper;

class LPoints extends RWPPayment
{
    protected $payout = null;

    public static function addPayment($paymentMethods)
    {
        $paymentMethods['lpoints'] = new self();

        return $paymentMethods;
    }

    public function getPaymentSource()
    {
        return [
            'name' => 'Loyalty Points',
            'value' => 'lpoints',
            'label' => 'Payment as Loyalty Points',
            'description' => 'Process Payouts for your affiliates through Loyalty Points',
            'note' => 'Process Payouts for your affiliates through Loyalty Points',
            'target_url' => PluginHelper::getAdminDashboard(),
        ];
    }

    /**
     * @param $payout
     * @return void
     */
    public function process($payout_ids)
    {
        if (\ActionScheduler::is_initialized()) {
            as_schedule_single_action(strtotime("now"), 'wpr_process_lpoints_payouts', [$payout_ids]);
        } else {
            error_log('ActionScheduler not initialized so Unable to process Payouts Via Loyalty Points');
        }
    }

    public static function sendPayments($payout_ids)
    {
        $ids = implode("','", $payout_ids);

        $memberTable = Member::getTableName();
        $affiliateTable = Affiliate::getTableName();
        $payoutTable = Payout::getTableName();


        $payouts = Payout::query()
            ->select("{$payoutTable}.*, {$memberTable}.email as affiliate_email")
            ->leftJoin($affiliateTable, "$affiliateTable.id = $payoutTable.affiliate_id")
            ->leftJoin($memberTable, "$memberTable.id = $affiliateTable.member_id")
            ->where("{$payoutTable}.id in ('" . $ids . "')")
            ->get();

        $data = [];

        $existing_points = get_option(WPR_LPOINTS_WP_OPTION_KEY, "{}");

        $existing_points = json_decode($existing_points, true);


        foreach ($payouts as $payout) {
            if (in_array($payout->id, $payout_ids)) {
                $data[] = [
                    'affiliate_email' => $payout->affiliate_email,
                    'points' => static::getLPoints($existing_points, $payout->currency, $payout->amount),
                    'commission_amount' => $payout->amount,
                    'currency' => $payout->currency,
                    'affiliate_id' => $payout->affiliate_id,
                    'affiliate_payout_id' => $payout->id,
                ];
            }
        }


        foreach ($data as $item) {
            $response = apply_filters('wlr_add_point_custom_callback', [],  [
                'points' => $item['points'],
                'user_email' => $item['affiliate_email'],
                'relay_slug' =>  WPR_LPOINTS_PLUGIN_SLUG
            ]);

            if (isset($response['success']) && isset($response['data'])) {
                $status = $response['success'];
                $message = $response['data']['message'];
                if ($status) {
                    do_action('rwpa_payment_mark_as_succeeded', $item['affiliate_payout_id'], ['message' => $message]);
                    continue;
                }
            }

            $message = $message ?? 'Unable to Convert as Points. Please Try Again Later';
            do_action('rwpa_payment_mark_as_failed', $item['affiliate_payout_id'], ['message' => $message]);
        }
    }

    private static function getLPoints($existing_points, $currency_code, $amount)
    {
        $single_unit_point = $existing_points[$currency_code] ?? 1;
        $total_points = floor($amount) * $single_unit_point;
        return $total_points;
    }
}
