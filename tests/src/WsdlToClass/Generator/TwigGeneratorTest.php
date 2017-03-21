<?php
namespace WsdlToClass\Generator;

use WsdlToClass\Wsdl\Wsdl;

/**
 *
 */
class TwigGeneratorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TwigGenerator
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new TwigGenerator;
        $this->object->setNamespace('DannyvdSluijs\WsdlToClass\UnitTest');
    }

    /**
     * @covers       \WsdlToClass\Generator\TwigGenerator::generateClassMap
     * @dataProvider wsdlDataProvider
     * @param Wsdl $wsdl
     */
    public function testGenerateClassMap(Wsdl $wsdl)
    {
        $classMap = $this->object->generateClassMap($wsdl);
        $this->assertStringStartsWith('<?php', $classMap);
        $this->assertNotFalse(eval(substr($classMap, 5)));
    }

    /**
     * @covers \WsdlToClass\Generator\TwigGenerator::generateStruct
     * @todo   Implement testGenerateStruct().
     */
    public function testGenerateStruct()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \WsdlToClass\Generator\TwigGenerator::generateService
     * @dataProvider wsdlDataProvider
     */
    public function testGenerateService(Wsdl $wsdl)
    {
        $service = $this->object->generateService($wsdl);
        $this->assertStringStartsWith('<?php', $service);
        $this->assertNotFalse(eval(substr($service, 5)));
    }

    /**
     * @covers \WsdlToClass\Generator\TwigGenerator::generateMethod
     * @todo   Implement testGenerateMethod().
     */
    public function testGenerateMethod()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \WsdlToClass\Generator\TwigGenerator::generateClient
     * @dataProvider wsdlDataProvider
     */
    public function testGenerateClient(Wsdl $wsdl)
    {
        $client = $this->object->generateClient($wsdl);
        $this->assertStringStartsWith('<?php', $client);
        $this->assertNotFalse(eval(substr($client, 5)));
    }

    public function wsdlDataProvider()
    {
        $wsdl = new Wsdl('http://wsf.cdyne.com/WeatherWS/Weather.asmx?WSDL');

        return array(
            'Weather cdyne.com' => array($wsdl)
        );
    }
}
