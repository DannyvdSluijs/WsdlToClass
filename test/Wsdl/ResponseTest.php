<?php

namespace WsdlToClassTest\Wsdl;

use WsdlToClass\Wsdl\Response;
use WsdlToClass\Wsdl\Struct;

/**
 *
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Response
     */
    private $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Response;
    }

    /**
     * @covers \WsdlToClass\Wsdl\Response::createFromStruct
     */
    public function testCreateFromStruct()
    {
        $struct = (new Struct())->setName('ExampleResponse');
        $request = Response::createFromStruct($struct);

        $this->assertInstanceOf(\WsdlToClass\Wsdl\Response::class, $request);
        $this->assertSame($request->getName(), 'ExampleResponse');
        $this->assertSame($request->getProperties(), []);
    }
}
