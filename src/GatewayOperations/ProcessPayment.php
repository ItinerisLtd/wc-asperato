<?php

declare(strict_types=1);

namespace Itineris\WCAsperato\GatewayOperations;

class ProcessPayment
{
    /**
     * Process Payment.
     *
     * Process the payment. Override this in your gateway. When implemented, this should.
     * return the success and redirect in an array. e.g:
     *
     *        return array(
     *            'result'   => 'success',
     *            'redirect' => $this->get_return_url( $order )
     *        );
     *
     * @param int $orderId Order ID.
     *
     * @return array
     */
    public function execute(int $orderId): array
    {
        $order = wc_get_order($orderId);
        wc_reduce_stock_levels($order);

        wc()->cart->empty_cart();

        return [
            'result' => 'success',
            'redirect' => $order->get_checkout_payment_url(true),
        ];
    }
}
