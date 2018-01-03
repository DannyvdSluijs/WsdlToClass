<?php

namespace WsdlToClassTest;

use org\bovigo\vfs\vfsStream;
use WsdlToClass\Generator\TwigGenerator;
use WsdlToClass\Parser\RegexParser;
use WsdlToClass\Util\Printer;
use WsdlToClass\Writer\ResourceWriter;
use WsdlToClass\Wsdl\Wsdl;
use WsdlToClass\WsdlToClass;

/**
 *
 */
class WsdlToClassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var WsdlToClass
     */
    private $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $wsdl = $this->createMock(\WsdlToClass\Wsdl\Wsdl::class);
        $parser = $this->createMock(\WsdlToClass\Parser\IParser::class);
        $generator = $this->createMock(\WsdlToClass\Generator\ICompositeGenerator::class);
        $writer = $this->createMock(\WsdlToClass\Writer\IWriter::class);
        $printer = $this->createMock(Printer::class);

        $this->object = new WsdlToClass($wsdl, '', 'Foo\Bar', $parser, $generator, $writer, $printer);
    }

    /**
     * @covers \WsdlToClass\WsdlToClass::__construct
     */
    public function testConstructor()
    {
        $wsdl = $this->createMock(\WsdlToClass\Wsdl\Wsdl::class);
        $parser = $this->createMock(\WsdlToClass\Parser\IParser::class);
        $generator = $this->createMock(\WsdlToClass\Generator\ICompositeGenerator::class);
        $writer = $this->createMock(\WsdlToClass\Writer\IWriter::class);
        $printer = $this->createMock(Printer::class);

        $object = new WsdlToClass($wsdl, '/tmp', 'Temporary\Unit\Test', $parser, $generator, $writer, $printer);

        $this->assertAttributeEquals($wsdl, 'wsdl', $object);
        $this->assertAttributeEquals('/tmp', 'destination', $object);
        $this->assertAttributeEquals('Temporary\Unit\Test', 'namespace', $object);
        $this->assertAttributeEquals($parser, 'parser', $object);
        $this->assertAttributeEquals($generator, 'generator', $object);
        $this->assertAttributeEquals($writer, 'writer', $object);
        $this->assertAttributeEquals($printer, 'printer', $object);
    }

    /**
     * @covers \WsdlToClass\WsdlToClass::getWsdl
     */
    public function testGetWsdl()
    {
        $this->assertInstanceOf('WsdlToClass\Wsdl\Wsdl', $this->object->getWsdl());
        $wsdl = $this->getMockBuilder('WsdlToClass\Wsdl\Wsdl')->disableOriginalConstructor()->getMock();
        $this->object->setWsdl($wsdl);
        $this->assertSame($wsdl, $this->object->getWsdl());
    }

    /**
     * @covers \WsdlToClass\WsdlToClass::setWsdl
     */
    public function testSetWsdl()
    {
        $wsdl = $this->getMockBuilder('WsdlToClass\Wsdl\Wsdl')->disableOriginalConstructor()->getMock();
        $this->assertSame($this->object, $this->object->setWsdl($wsdl));
        $this->assertAttributeSame($wsdl, 'wsdl', $this->object);
    }

    /**
     * @covers \WsdlToClass\WsdlToClass::getDestination
     */
    public function testGetDestination()
    {
        $this->assertSame('', $this->object->getDestination());
        $this->object->setDestination('/tmp');
        $this->assertSame('/tmp', $this->object->getDestination());
    }

    /**
     * @covers \WsdlToClass\WsdlToClass::setDestination
     */
    public function testSetDestination()
    {
        $this->assertSame($this->object, $this->object->setDestination('/dev/null'));
        $this->assertAttributeSame('/dev/null', 'destination', $this->object);
    }

    /**
     * @covers \WsdlToClass\WsdlToClass::getNamespace
     */
    public function testGetNamespacePrefix()
    {
        $this->assertSame('Foo\Bar', $this->object->getNamespace());
        $this->object->setNamespace('Soap\Test');
        $this->assertSame('Soap\Test', $this->object->getNamespace());
    }

    /**
     * @covers \WsdlToClass\WsdlToClass::setNamespace
     */
    public function testSetNamespacePrefix()
    {
        $this->assertSame($this->object, $this->object->setNamespace('Impl\Soap'));
        $this->assertAttributeSame('Impl\Soap', 'namespace', $this->object);
    }

    /**
     * @covers \WsdlToClass\WsdlToClass::getPrinter
     */
    public function testGetOutput()
    {
        $this->assertInstanceOf(Printer::class, $this->object->getPrinter());
        $printer = $this->createMock(Printer::class);
        $this->object->setPrinter($printer);
        $this->assertSame($printer, $this->object->getPrinter());
    }

    /**
     * @covers \WsdlToClass\WsdlToClass::setPrinter
     */
    public function testSetOutput()
    {
        $printer = $this->createMock(Printer::class);
        $this->assertSame($this->object, $this->object->setPrinter($printer));
        $this->assertAttributeSame($printer, 'printer', $this->object);
    }

    /**
     * @covers \WsdlToClass\WsdlToClass::getParser
     */
    public function testGetParser()
    {
        $this->assertInstanceOf('WsdlToClass\Parser\IParser', $this->object->getParser());
        $parser = $this->createMock('WsdlToClass\Parser\IParser');
        $this->object->setParser($parser);
        $this->assertSame($parser, $this->object->getParser());
    }

    /**
     * @covers \WsdlToClass\WsdlToClass::setParser
     */
    public function testSetParser()
    {
        $parser = $this->createMock('WsdlToClass\Parser\IParser');
        $this->assertSame($this->object, $this->object->setParser($parser));
        $this->assertAttributeSame($parser, 'parser', $this->object);
    }

    /**
     * @covers \WsdlToClass\WsdlToClass::getGenerator
     */
    public function testGetGenerator()
    {
        $this->assertInstanceOf('WsdlToClass\Generator\ICompositeGenerator', $this->object->getGenerator());
        $generator = $this->createMock('WsdlToClass\Generator\ICompositeGenerator');
        $this->object->setGenerator($generator);
        $this->assertSame($generator, $this->object->getGenerator());
    }

    /**
     * @covers \WsdlToClass\WsdlToClass::setGenerator
     */
    public function testSetGenerator()
    {
        $generator = $this->createMock('WsdlToClass\Generator\ICompositeGenerator');
        $this->assertSame($this->object, $this->object->setGenerator($generator));
        $this->assertAttributeSame($generator, 'generator', $this->object);
    }

    /**
     * @covers \WsdlToClass\WsdlToClass::execute
     * @covers \WsdlToClass\WsdlToClass::setupDirectoryStructure
     * @covers \WsdlToClass\WsdlToClass::parseWsdl
     * @covers \WsdlToClass\WsdlToClass::generateStructures
     * @covers \WsdlToClass\WsdlToClass::generateRequests
     * @covers \WsdlToClass\WsdlToClass::generateResponses
     * @covers \WsdlToClass\WsdlToClass::generateMethods
     * @covers \WsdlToClass\WsdlToClass::generateService
     * @covers \WsdlToClass\WsdlToClass::generateClient
     * @covers \WsdlToClass\WsdlToClass::generateClassMap
     */
    public function testExecute()
    {
        $root = vfsStream::setup('wsdltoclass', null, ['Output' => []]);

        $wsdl = new Wsdl('./data/wsdl/ip2geo.wsdl');
        $parser = new RegexParser();
        $generator = new TwigGenerator('php7');
        $writer = new ResourceWriter();
        $printer = $this->createMock(Printer::class);

        $object = new WsdlToClass($wsdl, vfsStream::url('wsdltoclass/Output'), 'Output', $parser, $generator, $writer, $printer);

        $object->execute();

        /* Assert directory structure was created */
        $this->assertTrue($root->hasChild('Output/Method'));
        $this->assertTrue($root->hasChild('Output/Structure'));
        $this->assertTrue($root->hasChild('Output/Request'));
        $this->assertTrue($root->hasChild('Output/Response'));

        /* Assert files */
        $this->assertTrue($root->hasChild('Output/ClassMap.php'));
        $this->assertTrue($root->hasChild('Output/Client.php'));
        $this->assertTrue($root->hasChild('Output/Service.php'));
        $this->assertTrue($root->hasChild('Output/Method/ResolveIP.php'));
        $this->assertTrue($root->hasChild('Output/Request/ResolveIP.php'));
        $this->assertTrue($root->hasChild('Output/Response/ResolveIPResponse.php'));
        $this->assertTrue($root->hasChild('Output/Structure/IPInformation.php'));
    }
}
