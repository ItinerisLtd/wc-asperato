<?php
declare(strict_types=1);

namespace Itineris\WCAsperato\AdminNotices;

use Codeception\Test\Unit;
use WP_Mock;

class MissingWooCommerceTest extends Unit
{
    /**
     * @var \Itineris\WCAsperato\UnitTester
     */
    protected $tester;

    public function testPrintAdminNoticeWhenWCExist()
    {
        WP_Mock::userFunction('Itineris\WCAsperato\AdminNotices\class_exists')
               ->with('WC_Payment_Gateway')
               ->andReturnTrue()
               ->once();

        $missingWooCommerce = new MissingWooCommerce();

        ob_start();
        $missingWooCommerce->printAdminNotice();
        $actual = ob_get_clean();

        $this->assertEmpty($actual);
    }

    public function testPrintAdminNoticeWhenWCNotExist()
    {
        WP_Mock::userFunction('Itineris\WCAsperato\AdminNotices\class_exists')
               ->with('WC_Payment_Gateway')
               ->andReturnFalse()
               ->once();

        $missingWooCommerce = new MissingWooCommerce();

        ob_start();
        $missingWooCommerce->printAdminNotice();
        $actual = ob_get_clean();

        $this->assertNotEmpty($actual);
    }
}
