<?php

namespace Phine\Compact\Tests\Exception;

use Phine\Compact\Exception\JsonException;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Performs unit tests on the `JsonException` class.
 *
 * @see JSONException
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class JsonExceptionTest extends TestCase
{
    /**
     * Make sure that we can retrieve an exception for the last error code.
     */
    public function testCreateUsingLastJsonError()
    {
        json_decode('{');

        $exception = JsonException::createUsingLastJsonError();

        $this->assertInstanceOf(
            'Phine\\Compact\\Exception\\JsonException',
            $exception,
            'An instance of JsonException should have been returned.'
        );

        $this->assertEquals(
            'Syntax error.',
            $exception->getMessage(),
            'The expected error message should be set.'
        );
    }
}
