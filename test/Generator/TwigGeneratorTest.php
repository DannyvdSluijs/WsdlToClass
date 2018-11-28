<?php

declare(strict_types=1);

namespace WsdlToClassTest\Generator;

use PHPUnit\Framework\TestCase;
use WsdlToClass\Generator\TwigGenerator;
use WsdlToClass\Wsdl\Method;
use WsdlToClass\Wsdl\Property;
use WsdlToClass\Wsdl\Struct;
use WsdlToClass\Wsdl\Wsdl;

/**
 *
 */
class TwigGeneratorTest extends TestCase
{
    /**
     * @var TwigGenerator
     */
    private $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new TwigGenerator('default');
        $this->object->setNamespace('DannyvdSluijs\WsdlToClass\UnitTest');
    }

    /**
     * @covers       \WsdlToClass\Generator\TwigGenerator::generateClassMap
     * @dataProvider wsdlDataProvider
     * @param Wsdl $wsdl
     */
    public function testGenerateClassMap(Wsdl $wsdl): void
    {
        $classMap = $this->object->generateClassMap($wsdl);
        $this->assertStringStartsWith('<?php', $classMap);
        $this->assertNotFalse(eval(substr($classMap, 5)));
    }

    /**
     * @covers \WsdlToClass\Generator\TwigGenerator::generateStruct
     */
    public function testGenerateStruct(): void
    {
        $struct = $this->object->generateStruct(new Struct(
            'BankAccount',
            [
                new Property('iban', 'string'),
                new Property('holder', 'string')
            ]
        ));
        $this->assertStringStartsWith('<?php', $struct);
        $this->assertNotFalse(eval(substr($struct, 5)));
    }

    /**
     * @covers       \WsdlToClass\Generator\TwigGenerator::generateService
     * @dataProvider wsdlDataProvider
     * @param Wsdl $wsdl
     */
    public function testGenerateService(Wsdl $wsdl): void
    {
        $service = $this->object->generateService($wsdl);
        $this->assertStringStartsWith('<?php', $service);
        $this->assertNotFalse(eval(substr($service, 5)));
    }

    /**
     * @covers \WsdlToClass\Generator\TwigGenerator::generateMethod
     * @todo   Implement testGenerateMethod().
     */
    public function testGenerateMethod(): void
    {
        $method = $this->object->generateMethod(new Method(
            'OpenBankAccount',
            'OpenBankAccountRequest',
            'OpenBankAccountresponse'
        ));
        $this->assertStringStartsWith('<?php', $method);
        $this->assertNotFalse(eval(substr($method, 5)));
    }

    /**
     * @covers       \WsdlToClass\Generator\TwigGenerator::generateClient
     * @dataProvider wsdlDataProvider
     * @param Wsdl $wsdl
     */
    public function testGenerateClient(Wsdl $wsdl): void
    {
        $client = $this->object->generateClient($wsdl);
        $this->assertStringStartsWith('<?php', $client);
        $this->assertNotFalse(eval(substr($client, 5)));
    }

    public function wsdlDataProvider(): array
    {
        return [
            'Weather cdyne.com' => [new Wsdl('http://wsf.cdyne.com/WeatherWS/Weather.asmx?WSDL')]
        ];
    }
}
