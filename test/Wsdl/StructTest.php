<?php

declare(strict_types=1);

namespace WsdlToClassTest\Wsdl;

use PHPUnit\Framework\TestCase;
use WsdlToClass\Wsdl\Struct;

/**
 *
 */
class StructTest extends TestCase
{
    /**
     * @var Struct
     */
    private $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Struct();
    }

    /**
     * @covers \WsdlToClass\Wsdl\Struct::getName
     */
    public function testGetName()
    {
        $this->assertEmpty($this->object->getName());
        $this->object->setName('identifier');
        $this->assertSame('identifier', $this->object->getName());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Struct::setName
     */
    public function testSetName()
    {
        $this->assertSame($this->object, $this->object->setName('address'));
        $this->assertAttributeSame('address', 'name', $this->object);
    }

    /**
     * @covers \WsdlToClass\Wsdl\Struct::getProperties
     */
    public function testGetProperties()
    {
        $property = $this->createMock('WsdlToClass\Wsdl\Property');
        $this->assertEmpty($this->object->getName());
        $this->object->setProperties(['identifier' => $property]);
        $this->assertContains($property, $this->object->getProperties());
        $this->assertArrayHasKey('identifier', $this->object->getProperties());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Struct::setProperties
     */
    public function testSetProperties()
    {
        $property = $this->createMock('WsdlToClass\Wsdl\Property');
        $this->assertSame($this->object, $this->object->setProperties(['identifier' => $property]));
    }

    /**
     * @covers \WsdlToClass\Wsdl\Struct::addProperty
     */
    public function testAddProperty()
    {
        $property = $this->createMock('WsdlToClass\Wsdl\Property');
        $property->expects($this->once())
            ->method('getName')
            ->willReturn('type');
        $this->assertSame($this->object, $this->object->addProperty($property));
        $this->assertContains($property, $this->object->getProperties());
        $this->assertArrayHasKey('type', $this->object->getProperties());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Struct::getProperty
     * @depends testAddProperty
     */
    public function testGetProperty()
    {
        $this->assertNull($this->object->getProperty('uuid'));
        $property = $this->createMock('WsdlToClass\Wsdl\Property');
        $property->expects($this->once())
            ->method('getName')
            ->willReturn('uuid');
        $this->object->addProperty($property);
        $this->assertSame($property, $this->object->getProperty('uuid'));
    }

    /**
     * @covers \WsdlToClass\Wsdl\Struct::hasProperty
     */
    public function testHasProperty()
    {
        $this->assertFalse($this->object->hasProperty('msisdn'));
        $property = $this->createMock('WsdlToClass\Wsdl\Property');
        $property->expects($this->once())
            ->method('getName')
            ->willReturn('msisdn');
        $this->object->addProperty($property);
        $this->assertTrue($this->object->hasProperty('msisdn'));
    }

    /**
     * @covers \WsdlToClass\Wsdl\Struct::visit
     */
    public function testVisit()
    {
        $mock = $this->createMock('WsdlToClass\Generator\IStructureGenerator');
        $mock->expects($this->once())
            ->method('generateStruct')
            ->with($this->object)
            ->willReturn('<?php echo "Hello world!"; ');
        $this->assertSame('<?php echo "Hello world!"; ', $this->object->visit($mock));
    }
}
