<?php

declare(strict_types=1);

namespace WsdlToClassTest\Unit\Wsdl;

use PHPUnit\Framework\TestCase;
use WsdlToClass\Wsdl\Response;
use WsdlToClass\Wsdl\Struct;

/**
 *
 */
class ResponseTest extends TestCase
{
    /**
     * @var Response
     */
    private $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new Response;
    }

    /**
     * @covers \WsdlToClass\Wsdl\Response::createFromStruct
     */
    public function testCreateFromStruct()
    {
        $struct = new Struct('ExampleResponse');
        $request = Response::createFromStruct($struct);

        $this->assertSame($request->getName(), 'ExampleResponse');
        $this->assertSame($request->getProperties(), []);
    }
}
