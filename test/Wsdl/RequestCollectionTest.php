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
use WsdlToClass\Wsdl\Request;
use WsdlToClass\Wsdl\RequestCollection;

/**
 * Unit test for the request collection class
 */
class RequestCollectionTest extends TestCase
{
    /**
     * Test the constructor
     * @covers \WsdlToClass\Wsdl\RequestCollection::__construct()
     */
    public function testConstructor()
    {
        $collection = new RequestCollection((new Request())->setName('One'), (new Request())->setName('Two'));
        $this->assertCount(2, $collection);
        $this->assertContainsOnly(Request::class, $collection->toArray());

        return $collection;
    }

    /**
     * Test the add function
     * @depends testConstructor
     * @covers \WsdlToClass\Wsdl\RequestCollection::add()
     * @param RequestCollection $collection
     */
    public function testAdd(RequestCollection $collection)
    {
        $count = count($collection);
        $collection->add((new Request())->setName('Three'));

        $this->assertCount($count + 1, $collection);
    }
}
