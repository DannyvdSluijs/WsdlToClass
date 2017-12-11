<?php

namespace WsdlToClassTest;

use Symfony\Component\Console\Output\OutputInterface;
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
        $output = $this->createMock(OutputInterface::class);

        $this->object = new WsdlToClass($wsdl, '', '', $parser, $generator, $writer, $output);
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
        $output = $this->createMock(OutputInterface::class);

        $object = new WsdlToClass($wsdl, '/tmp', '\Temporary\Unit\Test', $parser, $generator, $writer, $output);

        $this->assertAttributeEquals($wsdl, 'wsdl', $object);
        $this->assertAttributeEquals('/tmp', 'destination', $object);
        $this->assertAttributeEquals('\Temporary\Unit\Test', 'namespacePrefix', $object);
        $this->assertAttributeEquals($parser, 'parser', $object);
        $this->assertAttributeEquals($generator, 'generator', $object);
        $this->assertAttributeEquals($writer, 'writer', $object);
        $this->assertAttributeEquals($output, 'output', $object);
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
     * @covers \WsdlToClass\WsdlToClass::getNamespacePrefix
     */
    public function testGetNamespacePrefix()
    {
        $this->assertSame('', $this->object->getNamespacePrefix());
        $this->object->setNamespacePrefix('Soap\Test');
        $this->assertSame('Soap\Test', $this->object->getNamespacePrefix());
    }

    /**
     * @covers \WsdlToClass\WsdlToClass::setNamespacePrefix
     */
    public function testSetNamespacePrefix()
    {
        $this->assertSame($this->object, $this->object->setNamespacePrefix('Impl\Soap'));
        $this->assertAttributeSame('Impl\Soap', 'namespacePrefix', $this->object);
    }

    /**
     * @covers \WsdlToClass\WsdlToClass::getOutput
     */
    public function testGetOutput()
    {
        $this->assertInstanceOf(OutputInterface::class, $this->object->getOutput());
        $output = $this->createMock(OutputInterface::class);
        $this->object->setOutput($output);
        $this->assertSame($output, $this->object->getOutput());
    }

    /**
     * @covers \WsdlToClass\WsdlToClass::setOutput
     */
    public function testSetOutput()
    {
        $output = $this->createMock(OutputInterface::class);
        $this->assertSame($this->object, $this->object->setOutput($output));
        $this->assertAttributeSame($output, 'output', $this->object);
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
     * @todo   Implement testExecute().
     */
    public function testExecute()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
