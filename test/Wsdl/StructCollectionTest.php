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

use WsdlToClass\Wsdl\Struct;
use WsdlToClass\Wsdl\StructCollection;

/**
 * Unit test for the struct collection class
 */
class StructCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test the constructor
     * @covers \WsdlToClass\Wsdl\StructCollection::__construct()
     */
    public function testConstructor()
    {
        $collection = new StructCollection((new Struct())->setName('One'), (new Struct())->setName('Two'));
        $this->assertCount(2, $collection);
        $this->assertContainsOnly(Struct::class, $collection->toArray());

        return $collection;
    }

    /**
     * Test the add function
     * @depends testConstructor
     * @covers \WsdlToClass\Wsdl\StructCollection::add()
     * @param StructCollection $collection
     */
    public function testAdd(StructCollection $collection)
    {
        $count = count($collection);
        $collection->add((new Struct())->setName('Three'));

        $this->assertCount($count + 1, $collection);
    }
}
