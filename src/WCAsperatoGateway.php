<?php
declare(strict_types=1);

namespace Itineris\WCAsperato;

use Itineris\WCAsperato\GatewayOperations\ProcessPayment;
use Itineris\WCAsperato\GatewayOperations\Receipt;
use WC_Payment_Gateway;

/**
 * The main class.
 *
 * @see https://docs.woocommerce.com/document/payment-gateway-api/
 */
class WCAsperatoGateway extends WC_Payment_Gateway
{
    /**
     * WCAsperatoGateway constructor.
     */
    public function __construct()
    {
        $this->id = 'wc-asperato';
        $this->has_fields = false;
        $this->method_title = __('Asperato', 'wc-asperato');
        $this->method_description = __('Take payments via Asperato', 'wc-asperato');

        $this->init_form_fields();
        $this->init_settings();

        $this->title = $this->get_option('title');
        $this->description = $this->get_option('description');

        $receipt = new Receipt($this);
        add_action('woocommerce_receipt_' . $this->id, [$receipt, 'render']);

        add_action('woocommerce_update_options_payment_gateways_' . $this->id, [$this, 'process_admin_options']);
    }

    /**
     * Initialise settings form fields.
     *
     * Add an array of fields to be displayed on the gateway's settings screen.
     *
     * @return void
     */
    public function init_form_fields(): void
    {
        $this->form_fields = [
            'enabled' => [
                'title' => __('Enable/Disable', 'woocommerce'),
                'type' => 'checkbox',
                'label' => __('Enable Asperato', 'woocommerce'),
                'default' => 'yes',
            ],
            'title' => [
                'title' => __('Title', 'woocommerce'),
                'type' => 'text',
                'description' => __('This controls the title which the user sees during checkout.', 'woocommerce'),
                'default' => __('Asperato', 'wc-asperato'),
                'desc_tip' => true,
            ],
            'description' => [
                'title' => __('Description', 'woocommerce'),
                'type' => 'textarea',
                'desc_tip' => true,
                'description' => __(
                    'This controls the description which the user sees during checkout.',
                    'woocommerce'
                ),
                'default' => __('Pay via Asperato', 'wc-asperato'),
            ],
            'environment' => [
                'title' => 'Environment',
                'type' => 'select',
                'default' => 'test',
                'options' => [
                    'test' => __('Test', 'wc-asperato'),
                    'production' => __('Production (this plugin is not production-ready)', 'wc-asperato'),
                ],
            ],
            'pmRef' => [
                'title' => __('pmRef', 'woocommerce'),
                'type' => 'text',
                'desc_tip' => true,
                'description' => __(
                    'pmRef is a customer reference that can be derived from Salesforce. If you are using the ecommerce URL field from the payment object then this will already be included in the URL content.', // phpcs:ignore
                    'woocommerce'
                ),
                'default' => '903',
            ],
        ];
    }

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
    public function process_payment($orderId): array
    {
        $operation = new ProcessPayment();
        return $operation->execute($orderId);
    }
}
