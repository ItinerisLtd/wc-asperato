<?php

declare(strict_types=1);

namespace Itineris\WCAsperato\GatewayOperations;

use WC_Order;
use WC_Payment_Gateway;

class Receipt
{
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

        echo '<iframe id="asperato" src="';
        echo esc_url($this->iframeUrl($order));
        echo '" height="1000" width="500"></iframe>';
    }

    protected function endpoint(): string
    {
        $environment = $this->gateway->get_option('environment', 'test');

        return 'production' === $environment
            ? 'https://protectedpayments.net' // TODO: Asperato docs not found!!
            : 'https://test.protectedpayments.net';
    }

    protected function redirectUrl(WC_Order $order): string
    {
        return str_replace(
            'https:',
            'http:',
            add_query_arg([
                'wc-api' => 'wp_asperato',
                'orderId' => $order->get_id(),
            ], home_url('/'))
        );
    }

    protected function iframeUrl(WC_Order $order): string
    {
        return add_query_arg([
            // TODO: Asperato docs not found!!
            'pmRef' => $this->gateway->get_option('pmRef', '903'),
            // TODO: Asperato docs not found!!
            'camid' => $this->gateway->get_option('camid', '7010Y000000DTD1'),
            'DLamount' => (float) $order->get_total(),
            'DLcurrency' => get_woocommerce_currency(),
            'DLemail' => $order->get_billing_email(),
        ], $this->endpoint() . '/PMWeb1'); // TODO: Asperato docs not found!!
    }
}
