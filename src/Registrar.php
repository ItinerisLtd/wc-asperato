<?php
declare(strict_types=1);

namespace Itineris\WCAsperato;

class Registrar
{
    /**
     * Register WCAsperatoGateway to WooCommerce.
     *
     * @param string[] $gateways Array of all registered WooCommerce payment gateway classes.
     *
     * @return string[]
     */
    public function registerGatewayClass(array $gateways): array
    {
        $gateways[] = WCAsperatoGateway::class;
        return $gateways;
    }
}
