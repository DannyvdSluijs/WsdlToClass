<?php
/**
 * WsdlToClass
 *
 * PHP Version 7.1
 *
 * @copyright 2015-2018 Danny van der Sluijs <danny.vandersluijs@icloud.com>
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU-GPL
 * @link      http://dannyvandersluijs.nl
 */

declare(strict_types=1);

namespace WsdlToClassTest\Unit\Wsdl;

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
        $collection = new ResponseCollection(new Response('One'), new Response('Two'));
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
        $collection->add(new Response('Three'));

        $this->assertCount($count + 1, $collection);
    }
}
