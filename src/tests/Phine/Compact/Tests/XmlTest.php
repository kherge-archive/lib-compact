<?php

namespace Phine\Compact\Tests;

use Phine\Compact\Xml;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Performs unit tests on the `Xml` class.
 *
 * @see Xml
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class XmlTest extends TestCase
{
    /**
     * The JSON instance being tested.
     *
     * @var Xml
     */
    private $xml;

    /**
     * Make sure that the contents are compacted.
     */
    public function testCompactContents()
    {
        $this->assertEquals(
            "<?xml version=\"1.0\"?>\n<root><nested><child/></nested></root>",
            $this->xml->compactContents(
                <<<JSON
<?xml version="1.0"?>
<root>
  <nested>
    <child/>
  </nested>
</root>
JSON
            ),
            'The contents should be compacted.'
        );

        $this->setExpectedException(
            'Phine\\Compact\\Exception\\XmlException',
            '#1.) "StartTag: invalid element name" in  line 1 column 2.'
        );

        $this->xml->compactContents('<');
    }

    /**
     * Creates a new XML instance for testing.
     */
    protected function setUp()
    {
        $this->xml = new Xml();
    }
}
