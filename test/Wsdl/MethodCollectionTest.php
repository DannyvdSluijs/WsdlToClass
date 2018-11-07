<?php
/**
 * WsdlToClass
 *
 * PHP Version 7.1
 *
 * @copyright 2015-2017 Danny van der Sluijs <danny.vandersluijs@icloud.com>
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU-GPL
 * @link      http://dannyvandersluijs.nl
 */

declare(strict_types=1);

namespace WsdlToClassTest\Wsdl;

use PHPUnit\Framework\TestCase;
use WsdlToClass\Wsdl\Method;
use WsdlToClass\Wsdl\MethodCollection;

/**
 * Unit test for the method collection class
 */
class MethodCollectionTest extends TestCase
{
    /**
     * Test the constructor
     * @covers \WsdlToClass\Wsdl\MethodCollection::__construct()
     */
    public function testConstructor()
    {
        $collection = new MethodCollection((new Method())->setName('One'), (new Method())->setName('Two'));
        $this->assertCount(2, $collection);
        $this->assertContainsOnly(Method::class, $collection->toArray());

        return $collection;
    }

    /**
     * Test the add function
     * @depends testConstructor
     * @covers \WsdlToClass\Wsdl\MethodCollection::add()
     * @param MethodCollection $collection
     */
    public function testAdd(MethodCollection $collection)
    {
        $count = count($collection);
        $collection->add((new Method())->setName('Three'));

        $this->assertCount($count + 1, $collection);
    }
}
