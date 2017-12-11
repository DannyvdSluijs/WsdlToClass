<?php

namespace WsdlToClassTest\Wsdl;

use WsdlToClass\Wsdl\Method;

/**
 *
 */
class MethodTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Method
     */
    private $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Method;
    }

    /**
     * @covers \WsdlToClass\Wsdl\Method::getName
     */
    public function testGetName()
    {
        $this->assertEmpty($this->object->getName());
        $this->object->setName('save');
        $this->assertSame('save', $this->object->getName());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Method::setName
     */
    public function testSetName()
    {
        $this->assertSame($this->object, $this->object->setName('save'));
        $this->assertAttributeSame('save', 'name', $this->object);
    }

    /**
     * @covers \WsdlToClass\Wsdl\Method::getRequest
     */
    public function testGetRequest()
    {
        $this->assertEmpty($this->object->getRequest());
        $this->object->setRequest('request');
        $this->assertSame('request', $this->object->getRequest());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Method::setRequest
     */
    public function testSetRequest()
    {
        $this->assertSame($this->object, $this->object->setRequest('request'));
        $this->assertAttributeSame('request', 'request', $this->object);
    }

    /**
     * @covers \WsdlToClass\Wsdl\Method::getResponse
     */
    public function testGetResponse()
    {
        $this->assertEmpty($this->object->getResponse());
        $this->object->setResponse('response');
        $this->assertSame('response', $this->object->getResponse());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Method::setResponse
     */
    public function testSetResponse()
    {
        $this->assertSame($this->object, $this->object->setResponse('response'));
        $this->assertAttributeSame('response', 'response', $this->object);
    }

    /**
     * @covers \WsdlToClass\Wsdl\Method::visit
     */
    public function testVisit()
    {
        $mock = $this->createMock('WsdlToClass\Generator\IMethodGenerator');
        $mock->expects($this->once())->method('generateMethod')->with($this->object)->willReturn('<?php echo "Hello world!"; ');
        $this->assertSame('<?php echo "Hello world!"; ', $this->object->visit($mock));
    }
}
