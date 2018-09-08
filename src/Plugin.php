<?php
declare(strict_types=1);

namespace Itineris\WCAsperato;

use Itineris\WCAsperato\AdminNotices\MissingWooCommerce;
use Itineris\WCAsperato\GatewayOperations\CallbackHandler;

class Plugin
{
    /**
     * Begins execution of the plugin.
     *
     * @return void
     */
    public function run(): void
    {
        if (! class_exists('WC_Payment_Gateway')) {
            add_action('admin_notices', [MissingWooCommerce::class, 'printAdminNotice']);
        }

        $registrar = new Registrar();
        add_filter('woocommerce_payment_gateways', [$registrar, 'registerGatewayClass']);

        $callbackHandler = new CallbackHandler();
        add_action('woocommerce_api_wp_asperato', [$callbackHandler, 'markAsOnHold']);
    }
}
