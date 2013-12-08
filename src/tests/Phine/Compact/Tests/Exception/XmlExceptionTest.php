<?php

namespace Phine\Compact\Tests\Exception;

use DOMDocument;
use Phine\Compact\Exception\XmlException;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Performs unit tests on the `XmlException` class.
 *
 * @see XMLException
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class XmlExceptionTest extends TestCase
{
    /**
     * Make sure that we can get an exception for the libxml errors.
     */
    public function testCreateUsingLastXmlError()
    {
        $exception = new XmlException();
        $exception->start();

        $doc = new DOMDocument();
        $doc->formatOutput = false;
        $doc->preserveWhiteSpace = false;

        $doc->loadXML('<');

        $exception = $exception->createUsingLastXmlError();

        $this->assertInstanceOf(
            'Phine\\Compact\\Exception\\XmlException',
            $exception,
            'An instance of XmlException should have been returned.'
        );

        $this->assertEquals(
            '#1.) "StartTag: invalid element name" in  line 1 column 2.',
            $exception->getMessage(),
            'The libxml error message should be returned.'
        );

        $exception = new XmlException();
        $exception->start();

        $exception = $exception->createUsingLastXmlError();

        $this->assertEquals(
            '(unknown error)',
            $exception->getMessage(),
            'The default message should be returned if there are none.'
        );
    }
}
