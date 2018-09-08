<?php
declare(strict_types=1);

namespace Itineris\WCAsperato\GatewayOperations;

use WC_Order;

class CallbackHandler
{
    public function markAsOnHold(): void
    {
        $order = $this->getOrder();
        if (null === $order) {
            wp_safe_redirect(
                home_url()
            );
            exit;
        }

        // Mark as on-hold (we're waiting for somebody else to confirm it from Salesforce).
        $order->update_status('on-hold', __('Awaiting Salesforce confirmation', 'wc-asperato'));

        wp_safe_redirect(
            $order->get_view_order_url()
        );
        exit;
    }

    protected function getOrder(): ?WC_Order
    {
        $order = null;

        if (isset($_GET['orderId'])) { // WPCS: CSRF ok.
            $orderId = absint($_GET['orderId']);
            $order = wc_get_order($orderId);
        }

        return $order instanceof WC_Order
            ? $order
            : null;
    }
}
