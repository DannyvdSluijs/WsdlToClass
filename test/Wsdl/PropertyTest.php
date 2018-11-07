<?php

declare(strict_types=1);

namespace WsdlToClassTest\Wsdl;

use PHPUnit\Framework\TestCase;
use WsdlToClass\Wsdl\Property;

/**
 *
 */
class PropertyTest extends TestCase
{
    /**
     * @var Property
     */
    private $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Property();
    }

    /**
     * @covers \WsdlToClass\Wsdl\Property::__construct
     */
    public function testConstructor()
    {
        $this->object = new Property('location', 'string');
        $this->assertSame('location', $this->object->getName());
        $this->assertSame('string', $this->object->getType());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Property::getName
     */
    public function testGetName()
    {
        $this->assertEmpty($this->object->getName());
        $this->object->setName('identifier');
        $this->assertSame('identifier', $this->object->getName());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Property::setName
     */
    public function testSetName()
    {
        $this->assertSame($this->object, $this->object->setName('address'));
        $this->assertAttributeSame('address', 'name', $this->object);
    }

    /**
     * @covers \WsdlToClass\Wsdl\Property::getType
     */
    public function testGetType()
    {
        $this->assertEmpty($this->object->getType());
        $this->object->setType('string');
        $this->assertSame('string', $this->object->getType());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Property::setType
     */
    public function testSetType()
    {
        $this->assertSame($this->object, $this->object->setType('integer'));
        $this->assertAttributeSame('integer', 'type', $this->object);
    }
}
