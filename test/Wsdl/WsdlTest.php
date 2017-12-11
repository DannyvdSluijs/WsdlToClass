<?php

namespace WsdlToClassTest\Wsdl;

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
        $this->object->setSource('http://wsf.cdyne.com/WeatherWS/Weather.asmx?WSDL');
        $this->assertSame('http://wsf.cdyne.com/WeatherWS/Weather.asmx?WSDL', $this->object->getSource());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::setSource
     */
    public function testSetSource()
    {
        $this->assertSame($this->object, $this->object->setSource('http://www.webservicex.net/CurrencyConvertor.asmx?WSDL'));
        $this->assertAttributeSame('http://www.webservicex.net/CurrencyConvertor.asmx?WSDL', 'source', $this->object);
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::addStruct
     * @covers \WsdlToClass\Wsdl\Wsdl::add
     */
    public function testAddStruct()
    {
        $struct = $this->getMockBuilder('WsdlToClass\Wsdl\Struct')
            ->disableOriginalConstructor()
            ->getMock();
        $this->assertSame($this->object, $this->object->addStruct('mock', $struct));
        $this->assertAttributeContains($struct, 'structures', $this->object);

        return $this->object;
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::getStructures
     */
    public function testGetStructures()
    {
        $this->assertEmpty($this->object->getStructures());
        $struct = $this->getMockBuilder('WsdlToClass\Wsdl\Struct')->disableOriginalConstructor()->getMock();
        $this->object->addStruct('mock', $struct);
        $this->assertContainsOnly('WsdlToClass\Wsdl\Struct', $this->object->getStructures());
        $this->assertContains($struct, $this->object->getStructures());
        $this->assertArrayHasKey('mock', $this->object->getStructures());
    }

    /**
     * @covers  \WsdlToClass\Wsdl\Wsdl::getStruct
     * @covers  \WsdlToClass\Wsdl\Wsdl::get
     * @depends testAddStruct
     * @param Wsdl $wsdl
     * @return Wsdl
     */
    public function testGetStruct(Wsdl $wsdl)
    {
        $this->assertInstanceOf('WsdlToClass\Wsdl\Struct', $wsdl->getStruct('mock'));

        return $wsdl;
    }

    /**
     * @covers  \WsdlToClass\Wsdl\Wsdl::hasStruct()
     * @covers  \WsdlToClass\Wsdl\Wsdl::has()
     * @depends testGetStruct
     * @param Wsdl $wsdl
     */
    public function testHasStruct(Wsdl $wsdl)
    {
        $this->assertFalse($wsdl->hasStruct('Bananas'));
        $this->assertTrue($wsdl->hasStruct('mock'));
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::addMethod
     * @covers \WsdlToClass\Wsdl\Wsdl::add
     */
    public function testAddMethod()
    {
        $method = $this->getMockBuilder('WsdlToClass\Wsdl\Method')->disableOriginalConstructor()->getMock();
        $request = $this->getMockBuilder('WsdlToClass\Wsdl\Request')->disableOriginalConstructor()->getMock();
        $response = $this->getMockBuilder('WsdlToClass\Wsdl\Response')->disableOriginalConstructor()->getMock();
        $request->expects($this->any())->method('getProperties')->willReturn(array());
        $response->expects($this->any())->method('getProperties')->willReturn(array());
        $method->expects($this->any())->method('getRequest')->willReturn('request');
        $method->expects($this->any())->method('getResponse')->willReturn('response');
        $this->object->addStruct('response', $response);
        $this->object->addStruct('request', $request);
        $this->assertSame($this->object, $this->object->addMethod('method', $method));
        $this->assertAttributeContains($method, 'methods', $this->object);
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::getMethods
     */
    public function testGetMethods()
    {
        $this->assertEmpty($this->object->getMethods());
        $method = $this->getMockBuilder('WsdlToClass\Wsdl\Method')->disableOriginalConstructor()->getMock();
        $this->object->addMethod('method', $method);
        $this->assertContainsOnly('WsdlToClass\Wsdl\Method', $this->object->getMethods());
        $this->assertContains($method, $this->object->getMethods());
        $this->assertArrayHasKey('method', $this->object->getMethods());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::addRequest
     * @covers \WsdlToClass\Wsdl\Wsdl::add
     */
    public function testAddRequest()
    {
        $request = $this->getMockBuilder('WsdlToClass\Wsdl\Request')->disableOriginalConstructor()->getMock();
        $this->assertSame($this->object, $this->object->addRequest('request', $request));
        $this->assertAttributeContains($request, 'requests', $this->object);
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::getRequests
     */
    public function testGetRequests()
    {
        $this->assertEmpty($this->object->getRequests());
        $request = $this->getMockBuilder('WsdlToClass\Wsdl\Request')->disableOriginalConstructor()->getMock();
        $this->object->addRequest('request', $request);
        $this->assertContainsOnly('WsdlToClass\Wsdl\Request', $this->object->getRequests());
        $this->assertContains($request, $this->object->getRequests());
        $this->assertArrayHasKey('request', $this->object->getRequests());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::hasRequest
     * @todo   Implement testHasRequest().
     */
    public function testHasRequest()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::addResponse
     * @covers \WsdlToClass\Wsdl\Wsdl::add
     */
    public function testAddResponse()
    {
        $response = $this->getMockBuilder('WsdlToClass\Wsdl\Response')->disableOriginalConstructor()->getMock();
        $this->assertSame($this->object, $this->object->addResponse('response', $response));
        $this->assertAttributeContains($response, 'responses', $this->object);
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::getResponses
     */
    public function testGetResponses()
    {
        $this->assertEmpty($this->object->getResponses());
        $response = $this->getMockBuilder('WsdlToClass\Wsdl\Response')->disableOriginalConstructor()->getMock();
        $this->object->addResponse('mock', $response);
        $this->assertContainsOnly('WsdlToClass\Wsdl\Response', $this->object->getResponses());
        $this->assertContains($response, $this->object->getResponses());
        $this->assertArrayHasKey('mock', $this->object->getResponses());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::hasResponse
     * @todo   Implement testHasResponse().
     */
    public function testHasResponse()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::__toString
     */
    public function test__toString()
    {
        $this->object->setSource('http://wsf.cdyne.com/WeatherWS/Weather.asmx?WSDL');
        $this->assertSame('http://wsf.cdyne.com/WeatherWS/Weather.asmx?WSDL', (string) $this->object);
    }

    /**
     * @covers \WsdlToClass\Wsdl\Wsdl::visit
     */
    public function testVisit()
    {
        $mock = $this->createMock('WsdlToClass\Generator\IServiceGenerator');
        $mock->expects($this->once())->method('generateService')->with($this->object)->willReturn('<?php echo "Hello world!"; ');
        $this->assertSame('<?php echo "Hello world!"; ', $this->object->visit($mock));
    }
}
