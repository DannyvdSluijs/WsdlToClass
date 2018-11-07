<?php

declare(strict_types=1);

namespace WsdlToClassTest\Generator;

use PHPUnit\Framework\TestCase;
use WsdlToClass\Generator\AbstractGenerator;
use WsdlToClass\Generator\TwigGenerator;

/**
 *
 */
class AbstractGeneratorTest extends TestCase
{
    /**
     * @var AbstractGenerator
     */
    private $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new TwigGenerator('default');
    }

    /**
     * @covers \WsdlToClass\Generator\AbstractGenerator::getNamespace
     */
    public function testGetNamespace()
    {
        $this->assertEmpty($this->object->getNamespace());
        $this->object->setNamespace('\Soap\Messages');
        $this->assertSame('\Soap\Messages', $this->object->getNamespace());
    }

    /**
     * @covers \WsdlToClass\Generator\AbstractGenerator::setNamespace
     */
    public function testSetNamespace()
    {
        $this->assertSame($this->object, $this->object->setNamespace('\Soap\Method'));
        $this->assertAttributeSame('\Soap\Method', 'namespace', $this->object);
    }

    /**
     * @covers \WsdlToClass\Generator\AbstractGenerator::getChildNamespace
     */
    public function testGetChildNamespace()
    {
        $this->assertEmpty($this->object->getChildNamespace());
        $this->object->setChildNamespace('command');
        $this->assertSame('command', $this->object->getChildNamespace());
    }

    /**
     * @covers \WsdlToClass\Generator\AbstractGenerator::setChildNamespace
     */
    public function testSetChildNamespace()
    {
        $this->assertSame($this->object, $this->object->setChildNamespace('request'));
        $this->assertAttributeSame('request', 'childNamespace', $this->object);
    }

    /**
     * @covers \WsdlToClass\Generator\AbstractGenerator::getFullNamespace
     */
    public function testGetFullNamespace()
    {
        $this->assertEmpty($this->object->getFullNamespace());
        $this->object->setNamespace('\Random\Shizzle');
        $this->assertSame('\Random\Shizzle', $this->object->getFullNamespace());
        $this->object->setChildNamespace('MyNizzle');
        $this->assertSame('\Random\Shizzle\MyNizzle', $this->object->getFullNamespace());
    }
}
