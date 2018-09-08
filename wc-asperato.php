<?php
/**
 * Plugin Name:             WC Asperato
 * Plugin URI:              https://github.com/ItinerisLtd/wc-asperato
 * Description:             Asperato integration for WooCommerce
 * Version:                 0.1.0
 * Author:                  Itineris Limited
 * Author URI:              https://itineris.co.uk
 * License:                 GPL-2.0-or-later
 * License URI:             http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:             wc-asperato
 * WC requires at least:    3.4
 * WC tested up to:         3.4
 */

declare(strict_types=1);

namespace Itineris\WCAsperato;

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

/**
 * Begins execution of the plugin.
 *
 * @return void
 */
function run(): void
{
    $plugin = new Plugin();
    $plugin->run();
}

run();
