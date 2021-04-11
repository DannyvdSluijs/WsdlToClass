<?php

declare(strict_types=1);

namespace WsdlToClassTest\Unit\Wsdl;

use PHPUnit\Framework\TestCase;
use WsdlToClass\Wsdl\Request;
use WsdlToClass\Wsdl\Struct;

/**
 *
 */
class RequestTest extends TestCase
{
    /**
     * @var Request
     */
    private $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new Request;
    }

    /**
     * @covers \WsdlToClass\Wsdl\Request::createFromStruct
     */
    public function testCreateFromStruct(): void
    {
        $struct = new Struct('ExampleRequest');
        $request = Request::createFromStruct($struct);

        $this->assertSame($request->getName(), 'ExampleRequest');
        $this->assertSame($request->getProperties(), []);
    }
}
