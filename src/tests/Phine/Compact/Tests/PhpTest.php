<?php

namespace Phine\Compact\Tests;

use Phine\Compact\Php;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Performs unit tests on the `Php` class.
 *
 * @see Php
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class PhpTest extends TestCase
{
    /**
     * The PHP instance being tested.
     *
     * @var Php
     */
    private $php;

    /**
     * Make sure that the contents are compacted.
     */
    public function testCompactContents()
    {
        $this->assertEquals(
            <<<PHP
<?php

namespace Phine\Compact;

use Phine\Compact\Exception\CompactException;
use Phine\Compact\Exception\FileException;

















































interface CompactInterface
{















public function compactContents(\$contents);

















public function compactFile(\$file);


















public function isSupported(\$extension);
}
PHP
            ,
            $this->php->compactContents(
                file_get_contents(__DIR__ . '/../../../../lib/Phine/Compact/CompactInterface.php')
            ),
            'The contents should be compacted.'
        );
    }

    /**
     * Creates a new PHP instance for testing.
     */
    protected function setUp()
    {
        $this->php = new Php();
    }
}
