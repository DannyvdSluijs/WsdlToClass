<?php

declare(strict_types=1);

namespace WsdlToClassTest\Unit\Wsdl;

use PHPUnit\Framework\TestCase;
use WsdlToClass\Generator\IMethodGenerator;
use WsdlToClass\Wsdl\Method;

/**
 *
 */
class MethodTest extends TestCase
{
    /**
     * @var Method
     */
    private $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new Method('CreateBankAccount', 'CreateBankAccountRequest', 'CreateBankAccountResponse');
    }

    /**
     * @covers \WsdlToClass\Wsdl\Method::getName
     */
    public function testName(): void
    {
        $this->assertSame('CreateBankAccount', $this->object->getName());
        $this->object->setName('save');
        $this->assertSame('save', $this->object->getName());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Method::getRequest
     */
    public function testRequest()
    {
        $this->assertSame('CreateBankAccountRequest', $this->object->getRequest());
        $this->object->setRequest('request');
        $this->assertSame('request', $this->object->getRequest());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Method::getResponse
     */
    public function testResponse()
    {
        $this->assertSame('CreateBankAccountResponse', $this->object->getResponse());
        $this->object->setResponse('response');
        $this->assertSame('response', $this->object->getResponse());
    }

    /**
     * @covers \WsdlToClass\Wsdl\Method::visit
     */
    public function testVisit()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|IMethodGenerator $mock */
        $mock = $this->createMock(IMethodGenerator::class);
        $mock->expects($this->once())
            ->method('generateMethod')
            ->with($this->object)
            ->willReturn('<?php echo "Hello world!"; ');
        $this->assertSame('<?php echo "Hello world!"; ', $this->object->visit($mock));
    }
}
