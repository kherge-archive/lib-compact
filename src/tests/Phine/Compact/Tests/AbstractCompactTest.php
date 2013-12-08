<?php

namespace Phine\Compact\Tests;

use Phine\Compact\AbstractCompact;
use Phine\Test\Property;
use Phine\Test\Temp;
use PHPUnit_Framework_TestCase as TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Performs unit tests on the `AbstractCompact` class.
 *
 * @see AbstractCompact
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class AbstractCompactTest extends TestCase
{
    /**
     * The abstract mock being tested.
     *
     * @var AbstractCompact|MockObject
     */
    private $abstract;

    /**
     * The test file manager.
     *
     * @var Temp
     */
    private $temp;

    /**
     * Make sure that `compactFile()` returns the result of `compactContents()`.
     */
    public function testCompactFile()
    {
        $this
            ->abstract
            ->expects($this->once())
            ->method('compactContents')
            ->with($this->equalTo('file contents'))
            ->will($this->returnValue('file'));

        $file = $this->temp->createFile();

        file_put_contents($file, 'file contents');

        $this->assertEquals(
            'file',
            $this->abstract->compactFile($file),
            'The "file" string should have been returned.'
        );

        unlink($file);

        $this->setExpectedException(
            'Phine\\Compact\\Exception\\FileException',
            'failed to open stream: No such file or directory'
        );

        $this->abstract->compactFile($file);
    }

    /**
     * Make sure the abstract implements `isSupported()`.
     */
    public function testIsSupported()
    {
        $this->assertFalse(
            $this->abstract->isSupported('test'),
            'The "test" extension should not be supported.'
        );

        Property::set($this->abstract, 'extensions', array('test'));

        $this->assertTrue(
            $this->abstract->isSupported('test'),
            'The "test" extension should be supported.'
        );
    }

    /**
     * Make sure we can set an alternative list of supported file extensions.
     */
    public function testSetExtensions()
    {
        $extensions = array('abc', '123', 'test');

        $this->abstract->setExtensions($extensions);

        $this->assertEquals(
            $extensions,
            Property::get($this->abstract, 'extensions'),
            'The file extensions should have been set.'
        );
    }

    /**
     * Creates a mock of the abstract class for testing.
     */
    protected function setUp()
    {
        $this->abstract = $this->getMockForAbstractClass(
            'Phine\\Compact\\AbstractCompact'
        );

        $this->temp = new Temp();
    }
}
