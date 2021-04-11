<?php

declare(strict_types=1);

namespace WsdlToClassTest\Unit\Writer;

use PHPUnit\Framework\TestCase;
use WsdlToClass\Writer\ResourceWriter;

/**
 *
 */
class ResourceWriterTest extends TestCase
{
    /**
     * @var ResourceWriter
     */
    private $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->object = new ResourceWriter;
    }

    /**
     * @covers \WsdlToClass\Writer\ResourceWriter::writeFile
     */
    public function testWriteFile()
    {
        $filename = tempnam(sys_get_temp_dir(), 'phpunit_');
        $content = 'Random data 42';
        $this->object->writeFile($filename, $content);
        $this->assertFileExists($filename);
        $this->assertEquals($content, file_get_contents($filename));
    }
}
