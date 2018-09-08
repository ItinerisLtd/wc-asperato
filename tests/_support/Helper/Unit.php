<?php
declare(strict_types=1);

namespace Itineris\WCAsperato\Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Codeception\Module;
use Codeception\TestInterface;
use Mockery;
use WP_Mock;

class Unit extends Module
{
    public function _before(TestInterface $test)
    {
        WP_Mock::setUp();

        WP_Mock::userFunction('Itineris\WCAsperato\AdminNotices\__')
               ->with(Mockery::type('string'), 'wc-asperato')
               ->andReturnUsing(function ($arg) {
                   return $arg;
               })
               ->zeroOrMoreTimes();

        WP_Mock::userFunction('Itineris\WCAsperato\AdminNotices\wp_kses_post')
               ->with(Mockery::type('string'))
               ->andReturnUsing(function ($arg) {
                   return $arg;
               })
               ->zeroOrMoreTimes();
    }

    public function _after(TestInterface $test)
    {
        WP_Mock::tearDown();
        Mockery::close();
    }
}
