<?php

declare(strict_types=1);

namespace WsdlToClassTest\Wsdl;

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
    protected function setUp()
    {
        $this->object = new Request;
    }

    /**
     * @covers \WsdlToClass\Wsdl\Request::createFromStruct
     */
    public function testCreateFromStruct()
    {
        $struct = (new Struct())->setName('ExampleRequest')
            ->setProperties([]);
        $request = Request::createFromStruct($struct);

        $this->assertInstanceOf(\WsdlToClass\Wsdl\Request::class, $request);
        $this->assertSame($request->getName(), 'ExampleRequest');
        $this->assertSame($request->getProperties(), []);
    }
}
