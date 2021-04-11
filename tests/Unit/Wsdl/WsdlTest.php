<?php

declare(strict_types=1);

namespace WsdlToClassTest\Unit\Wsdl;

use PHPUnit\Framework\TestCase;
use WsdlToClass\Wsdl\Method;
use WsdlToClass\Wsdl\Struct;
use WsdlToClass\Wsdl\Wsdl;

/**
 *
 */
class WsdlTest extends TestCase
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
    public function testAddStruct(): Wsdl
    {
        $struct = $this->createMock(Struct::class);
        $this->object->addStruct($struct);
        $this->assertAttributeContains($struct, 'structures', $this->object);

        return $this->object;
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::getStructures
     */
    public function testGetStructures(): void
    {
        $this->assertEmpty($this->object->getStructures());
        $struct = new Struct('mock');
        $this->object->addStruct($struct);
        $this->assertContainsOnly(Struct::class, $this->object->getStructures()->toArray());
        $this->assertContains($struct, $this->object->getStructures());
        $this->assertArrayHasKey('mock', $this->object->getStructures()->toArray());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::addMethod
     */
    public function testAddMethod(): void
    {
        $request = $this->createMock(\WsdlToClass\Wsdl\Request::class);
        $response = $this->createMock(\WsdlToClass\Wsdl\Response::class);
        $method = new Method('test', 'request', 'response');

        $request->method('getProperties')
            ->willReturn([]);
        $response->method('getProperties')
            ->willReturn([]);
        $this->object->addStruct($response);
        $this->object->addStruct($request);
        $this->object->addMethod($method);

        $this->assertContains($method, $this->object->getMethods());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::getMethods
     */
    public function testGetMethods(): void
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
    public function testGetRequests(): void
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
    public function testGetResponses(): void
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
    public function testToString(): void
    {
        $this->assertSame('http://www.w3schools.com/webservices/tempconvert.asmx?WSDL', (string) $this->object);
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::visit
     */
    public function testVisit(): void
    {
        $mock = $this->createMock('WsdlToClass\Generator\IServiceGenerator');
        $mock->expects($this->once())
            ->method('generateService')
            ->with($this->object)
            ->willReturn('<?php echo "Hello world!"; ');
        $this->assertSame('<?php echo "Hello world!"; ', $this->object->visit($mock));
    }
}
