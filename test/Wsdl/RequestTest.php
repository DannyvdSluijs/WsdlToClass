<?php

namespace WsdlToClassTest\Wsdl;

use WsdlToClass\Wsdl\Request;

/**
 *
 */
class RequestTest extends \PHPUnit_Framework_TestCase
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
        $struct = $this->createMock('WsdlToClass\Wsdl\Struct');
        $struct->expects($this->once())->method('getName')->willReturn('ExampleRequest');
        $struct->expects($this->once())->method('getProperties')->willReturn(array());
        $request = Request::createFromStruct($struct);

        $this->assertInstanceOf('WsdlToClass\Wsdl\Request', $request);
        $this->assertSame($request->getName(), 'ExampleRequest');
        $this->assertSame($request->getProperties(), array());
    }
}
