<?php

namespace WsdlToClassTest\Wsdl;

use WsdlToClass\Wsdl\Method;
use WsdlToClass\Wsdl\Struct;
use WsdlToClass\Wsdl\Wsdl;

/**
 *
 */
class WsdlTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Wsdl
     */
    private $object;

    /**
     * Setup the object
     */
    protected function setUp()
    {
        $this->object = new Wsdl('http://www.w3schools.com/webservices/tempconvert.asmx?WSDL');
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::__construct
     */
    public function testConstruct()
    {
        $this->object = new Wsdl('http://www.w3schools.com/webservices/tempconvert.asmx?WSDL');
        $this->assertSame('http://www.w3schools.com/webservices/tempconvert.asmx?WSDL', $this->object->getSource());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::getSource
     */
    public function testGetSource()
    {
        $this->assertSame('http://www.w3schools.com/webservices/tempconvert.asmx?WSDL', $this->object->getSource());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::addStruct
     */
    public function testAddStruct()
    {
        $struct = $this->createMock(Struct::class);
        $this->assertSame($this->object, $this->object->addStruct($struct));
        $this->assertAttributeContains($struct, 'structures', $this->object);

        return $this->object;
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::getStructures
     */
    public function testGetStructures()
    {
        $this->assertEmpty($this->object->getStructures());
        $struct = (new Struct())->setName('mock');
        $this->object->addStruct($struct);
        $this->assertContainsOnly(Struct::class, $this->object->getStructures()->toArray());
        $this->assertContains($struct, $this->object->getStructures());
        $this->assertArrayHasKey('mock', $this->object->getStructures()->toArray());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::addMethod
     */
    public function testAddMethod()
    {
        $request = $this->createMock(\WsdlToClass\Wsdl\Request::class);
        $response = $this->createMock(\WsdlToClass\Wsdl\Response::class);
        $method = (new Method())->setName('test')
            ->setRequest('request')
            ->setResponse('response');

        $request->expects($this->any())
            ->method('getProperties')
            ->willReturn(array());
        $response->expects($this->any())
            ->method('getProperties')
            ->willReturn(array());
        $this->object->addStruct($response);
        $this->object->addStruct($request);
        $this->assertSame($this->object, $this->object->addMethod($method));

        $this->assertContains($method, $this->object->getMethods());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::getMethods
     */
    public function testGetMethods()
    {
        $this->assertEmpty($this->object->getMethods());
        $method = $this->createMock(\WsdlToClass\Wsdl\Method::class);
        $this->object->addMethod($method);
        $this->assertContainsOnly(\WsdlToClass\Wsdl\Method::class, $this->object->getMethods());
        $this->assertContains($method, $this->object->getMethods());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::getRequests
     */
    public function testGetRequests()
    {
        $this->assertEmpty($this->object->getRequests());
        $request = $this->createMock(\WsdlToClass\Wsdl\Request::class);
        $this->object->getRequests()->add($request);
        $this->assertContainsOnly(\WsdlToClass\Wsdl\Request::class, $this->object->getRequests());
        $this->assertContains($request, $this->object->getRequests());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::getResponses
     */
    public function testGetResponses()
    {
        $this->assertEmpty($this->object->getResponses());
        $response = $this->createMock(\WsdlToClass\Wsdl\Response::class);
        $this->object->getResponses()->add($response);
        $this->assertContainsOnly(\WsdlToClass\Wsdl\Response::class, $this->object->getResponses());
        $this->assertContains($response, $this->object->getResponses());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::__toString
     */
    public function test__toString()
    {
        $this->assertSame('http://www.w3schools.com/webservices/tempconvert.asmx?WSDL', (string) $this->object);
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::visit
     */
    public function testVisit()
    {
        $mock = $this->createMock('WsdlToClass\Generator\IServiceGenerator');
        $mock->expects($this->once())
            ->method('generateService')
            ->with($this->object)
            ->willReturn('<?php echo "Hello world!"; ');
        $this->assertSame('<?php echo "Hello world!"; ', $this->object->visit($mock));
    }
}
