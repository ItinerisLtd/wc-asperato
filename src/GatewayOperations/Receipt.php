<?php

declare(strict_types=1);

namespace Itineris\WCAsperato\GatewayOperations;

use WC_Order;
use WC_Payment_Gateway;

class Receipt
{
    public const PID_FILTER = 'wc_asperato_pid';

    /**
     * The gateway instance.
     *
     * @var WC_Payment_Gateway
     */
    protected $gateway;

    /**
     * Receipt constructor.
     *
     * @param WC_Payment_Gateway $gateway The gateway instance.
     */
    public function __construct(WC_Payment_Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * Displays the payment page
     *
     * @param int $orderId The order ID.
     *
     * @return void
     */
    public function render(int $orderId): void
    {
        $order = wc_get_order($orderId);

        $pid = apply_filters(static::PID_FILTER, null, $order);
        if (! is_string($pid)) {
            // Translators: %1$s is the filter tag.
            $message = esc_html__('WC Asperato: Unable to retrieve "pid". Did you hook into "%1$s"?', 'wc-asperato');
            $message = sprintf($message, static::PID_FILTER);
            echo esc_html($message);
            return;
        }

        wp_register_script(
            'wc-asperato-iframe',
            plugins_url('../js/iframe.js', __FILE__),
            [],
            '0.1.0',
            true
        );
        wp_localize_script('wc-asperato-iframe', 'wcAsperato', [
            'origin' => $this->endpoint(),
            'redirectUrl' => $this->redirectUrl($order),
        ]);
        wp_enqueue_script('wc-asperato-iframe');

        // TODO: Apply filters.
        echo '<iframe id="asperato" src="';
        echo esc_url($this->iframeUrl($order, $pid));
        echo '" height="1000" width="500"></iframe>';
    }

    /**
     * Asperato iFrame domain according to the environment.
     *
     * @return string
     */
    protected function endpoint(): string
    {
        $environment = $this->gateway->get_option('environment', 'test');

        return 'production' === $environment
            ? 'https://live.protectedpayments.net'
            : 'https://test.protectedpayments.net';
    }

    /**
     * Callback URL for a given order.
     *
     * @param WC_Order $order The order instance.
     *
     * @return string
     */
    protected function redirectUrl(WC_Order $order): string
    {
        // TODO: Figure out why WooCommerce docs not using HTTPS.
        return str_replace(
            'https:',
            'http:',
            add_query_arg([
                'wc-api' => 'wp_asperato',
                'orderId' => $order->get_id(),
            ], home_url('/'))
        );
    }

    /**
     * The iFrame src for a given order.
     *
     * @param WC_Order $order The order instance.
     * @param string   $pid   The Salesforce ID of the related payment object row.
     *
     * @return string
     */
    protected function iframeUrl(WC_Order $order, string $pid): string
    {
        // TODO: Apply filters.
        return add_query_arg([
            'pmRef' => $this->gateway->get_option('pmRef', '903'),
            'pid' => $pid,
            'DLamount' => (float) $order->get_total(),
            'DLcurrency' => get_woocommerce_currency(),
            'DLemail' => $order->get_billing_email(),
        ], $this->endpoint() . '/PMWeb1');
    }
}
