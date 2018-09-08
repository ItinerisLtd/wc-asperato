<?php
declare(strict_types=1);

namespace Itineris\WCAsperato;

use Itineris\WCAsperato\AdminNotices\MissingWooCommerce;

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
    }
}
