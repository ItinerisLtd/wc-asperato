<?php
declare(strict_types=1);

namespace Itineris\WCAsperato;

use Codeception\Test\Unit;

class RegistrarTest extends Unit
{
    /**
     * @var \Itineris\WCAsperato\UnitTester
     */
    protected $tester;

    public function testRegisterGatewayClass()
    {
        $registrar = new Registrar();

        $actual = $registrar->registerGatewayClass(['a', 'b']);

        $this->assertSame([
            'a',
            'b',
            WCAsperatoGateway::class,
        ], $actual);
    }
}
