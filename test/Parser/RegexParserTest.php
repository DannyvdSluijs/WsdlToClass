<?php

declare(strict_types=1);

namespace WsdlToClassTest\Parser;

use PHPUnit\Framework\TestCase;
use WsdlToClass\Parser\RegexParser;

/**
 *
 */
class RegexParserTest extends TestCase
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
 string dashed-value;
}
EOT
        );
        $this->assertInstanceOf('WsdlToClass\Wsdl\Struct', $result);
        $this->assertSame('ProductLine', $result->getName());
        $this->assertTrue($result->hasProperty('Mode'));
        $this->assertTrue($result->hasProperty('RelevanceRank'));
        $this->assertTrue($result->hasProperty('DashedValue'));
        $this->assertSame('string', $result->getProperty('Mode')->getType());
        $this->assertSame('Mode', $result->getProperty('Mode')->getName());
        $this->assertSame('string', $result->getProperty('RelevanceRank')->getType());
        $this->assertSame('RelevanceRank', $result->getProperty('RelevanceRank')->getName());
        $this->assertSame('string', $result->getProperty('DashedValue')->getType());
        $this->assertSame('DashedValue', $result->getProperty('DashedValue')->getName());
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
     * @covers \WsdlToClass\Parser\RegexParser::parseType
     */
    public function testParseTypeWithAnyXML()
    {
        $result = $this->object->parseType(<<<EOT
struct AbstractRequestType {
 DetailLevelCodeType DetailLevel;
 string ErrorLanguage;
 string Version;
 <anyXML> any;
}
EOT
        );
        $this->assertInstanceOf('WsdlToClass\Wsdl\Struct', $result);
        $this->assertSame('AbstractRequestType', $result->getName());
        $this->assertTrue($result->hasProperty('DetailLevel'));
        $this->assertTrue($result->hasProperty('ErrorLanguage'));
        $this->assertTrue($result->hasProperty('Version'));
        $this->assertTrue($result->hasProperty('Any'));
        $this->assertSame('DetailLevelCodeType', $result->getProperty('DetailLevel')->getType());
        $this->assertSame('DetailLevel', $result->getProperty('DetailLevel')->getName());
        $this->assertSame('string', $result->getProperty('ErrorLanguage')->getType());
        $this->assertSame('ErrorLanguage', $result->getProperty('ErrorLanguage')->getName());
        $this->assertSame('string', $result->getProperty('Version')->getType());
        $this->assertSame('Version', $result->getProperty('Version')->getName());
        $this->assertSame('string', $result->getProperty('Any')->getType());
        $this->assertSame('Any', $result->getProperty('Any')->getName());
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
