<?php

namespace Phine\Compact\Tests;

use Phine\Compact\Json;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Performs unit tests on the `Json` class.
 *
 * @see Json
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class JsonTest extends TestCase
{
    /**
     * The JSON instance being tested.
     *
     * @var Json
     */
    private $json;

    /**
     * Make sure that the contents are compacted.
     */
    public function testCompactContents()
    {
        $this->assertEquals(
            '{"test":123}',
            $this->json->compactContents(
                <<<JSON
{
    "test": 123
}
JSON
            ),
            'The contents should be compacted.'
        );

        $this->setExpectedException(
            'Phine\\Compact\\Exception\\JsonException',
            'Syntax error.'
        );

        $this->json->compactContents('{');
    }

    /**
     * Creates a new JSON instance for testing.
     */
    protected function setUp()
    {
        $this->json = new Json();
    }
}
