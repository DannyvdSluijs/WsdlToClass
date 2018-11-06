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
use WsdlToClass\Wsdl\Response;
use WsdlToClass\Wsdl\ResponseCollection;

/**
 * Unit test for the response collection class
 */
class ResponseCollectionTest extends TestCase
{
    /**
     * Test the constructor
     * @covers \WsdlToClass\Wsdl\ResponseCollection::__construct()
     */
    public function testConstructor()
    {
        $collection = new ResponseCollection((new Response())->setName('One'), (new Response())->setName('Two'));
        $this->assertCount(2, $collection);
        $this->assertContainsOnly(Response::class, $collection->toArray());

        return $collection;
    }

    /**
     * Test the add function
     * @depends testConstructor
     * @covers \WsdlToClass\Wsdl\ResponseCollection::add()
     * @param ResponseCollection $collection
     */
    public function testAdd(ResponseCollection $collection)
    {
        $count = count($collection);
        $collection->add((new Response())->setName('Three'));

        $this->assertCount($count + 1, $collection);
    }
}
