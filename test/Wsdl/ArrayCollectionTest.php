<?php
/**
 * WsdlToClass
 *
 * PHP Version 7.0
 *
 * @copyright 2015-2017 Danny van der Sluijs <danny.vandersluijs@icloud.com>
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU-GPL
 * @link      http://dannyvandersluijs.nl
 */

namespace WsdlToClassTest\Wsdl;

use PHPUnit\Framework\TestCase;
use WsdlToClass\Wsdl\ArrayCollection;
use WsdlToClass\Wsdl\Struct;
use WsdlToClass\Wsdl\StructCollection;

class ArrayCollectionTest extends TestCase
{
    /**
     * @var StructCollection
     */
    private $object;

    /**
     *
     */
    protected function setUp()
    {
        $this->object = new StructCollection(
            (new Struct())->setName('One'),
            (new Struct())->setName('Two'),
            (new Struct())->setName('Three')
        );
    }

    /**
     * @covers \WsdlToClass\Wsdl\ArrayCollection::addItem()
     */
    public function testAddItem()
    {
        $this->assertAttributeCount(3, 'items', $this->object);
        $this->object->add((new Struct())->setName('Four'));
        $this->assertAttributeCount(4, 'items', $this->object);

        return $this->object;
    }

    /**
     * @covers \WsdlToClass\Wsdl\ArrayCollection::addItem()
     * @depends testAddItem
     */
    public function testRemoveItem(ArrayCollection $collection)
    {
        $this->object = $collection;

        $this->assertAttributeCount(4, 'items', $this->object);
        $this->object->remove((new Struct())->setName('Four'));
        $this->assertAttributeCount(3, 'items', $this->object);
    }

    /**
     * @covers \WsdlToClass\Wsdl\ArrayCollection::has()
     */
    public function testHas()
    {
        $this->assertTrue($this->object->has('One'));
        $this->assertTrue($this->object->has('Two'));
        $this->assertTrue($this->object->has('Three'));
        $this->assertFalse($this->object->has('Four'));
    }

    /**
     * @covers \WsdlToClass\Wsdl\ArrayCollection::get()
     */
    public function testGet()
    {
        $this->assertInstanceOf(Struct::class, $this->object->get('One'));
        $this->assertSame('One', $this->object->get('One')->getName());
    }

    /**
     * @covers \WsdlToClass\Wsdl\ArrayCollection::get()
     */
    public function testGetForNonExistingItem()
    {
        $this->expectException(\RuntimeException::class);
        $this->object->get('Four');
    }

    /**
     * @covers \WsdlToClass\Wsdl\ArrayCollection::getIterator()
     */
    public function testGetIterator()
    {
        $this->assertInstanceOf(\ArrayIterator::class, $this->object->getIterator());
    }

    /**
     * @covers \WsdlToClass\Wsdl\ArrayCollection::toArray()
     */
    public function testToArray()
    {
        $this->assertArrayHasKey('One', $this->object->toArray());
        $this->assertArrayHasKey('Two', $this->object->toArray());
        $this->assertArrayHasKey('Three', $this->object->toArray());
        $this->assertArrayNotHasKey('Four', $this->object->toArray());
    }

    /**
     * @covers \WsdlToClass\Wsdl\ArrayCollection::count()
     */
    public function testCount()
    {
        $this->assertCount(3, $this->object);
    }
}
