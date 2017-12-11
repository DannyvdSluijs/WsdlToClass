<?php

namespace WsdlToClassTest\Parser;

use WsdlToClass\Parser\RegexParser;

/**
 *
 */
class RegexParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RegexParser
     */
    private $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new RegexParser();
    }

    /**
     * @covers \WsdlToClass\Parser\RegexParser::parseType
     */
    public function testParseType()
    {
        $result = $this->object->parseType(<<<EOT
struct ProductLine {
 string Mode;
 string RelevanceRank;
}
EOT
        );
        $this->assertInstanceOf('WsdlToClass\Wsdl\Struct', $result);
        $this->assertSame('ProductLine', $result->getName());
        $this->assertTrue($result->hasProperty('Mode'));
        $this->assertTrue($result->hasProperty('RelevanceRank'));
        $this->assertSame('string', $result->getProperty('Mode')->getType());
        $this->assertSame('Mode', $result->getProperty('Mode')->getName());
        $this->assertSame('string', $result->getProperty('RelevanceRank')->getType());
        $this->assertSame('RelevanceRank', $result->getProperty('RelevanceRank')->getName());
    }

    /**
     * @covers \WsdlToClass\Parser\RegexParser::parseType
     */
    public function testParseTypeArrayOfComplexType()
    {
        $result = $this->object->parseType('Message ArrayOfMessage[]');
        $this->assertInstanceOf('WsdlToClass\Wsdl\Struct', $result);
        $this->assertSame('ArrayOfMessage', $result->getName());
        $this->assertTrue($result->hasProperty('Message'));
        $this->assertSame('Message[]', $result->getProperty('Message')->getType());
    }

    /**
     * @covers \WsdlToClass\Parser\RegexParser::parseType
     */
    public function testParseSimpleType()
    {
        $result = $this->object->parseType('string DeliveryStatus');
        $this->assertInstanceOf('WsdlToClass\Wsdl\Property', $result);
        $this->assertSame('DeliveryStatus', $result->getName());
        $this->assertSame('string', $result->getType());
    }

    /**
     * @covers \WsdlToClass\Parser\RegexParser::parseType
     */
    public function testParseTypeInvalidInput()
    {
        $this->expectException(\Exception::class);
        $this->object->parseType('');
    }

    /**
     * @covers \WsdlToClass\Parser\RegexParser::parseFunction
     */
    public function testParseFunction()
    {
        $result = $this->object->parseFunction('Address getAddress(Postcode $postcode)');
        $this->assertInstanceOf('WsdlToClass\Wsdl\Method', $result);
        $this->assertSame('getAddress', $result->getName());
        $this->assertSame('Postcode', $result->getRequest());
        $this->assertSame('Address', $result->getResponse());
    }

    /**
     * @covers \WsdlToClass\Parser\RegexParser::parseFunction
     */
    public function testParseFunctionInvalidInput()
    {
        $this->expectException(\Exception::class);
        $this->object->parseFunction('');
    }
}
