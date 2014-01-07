<?php

namespace Phine\Compact\Tests;

use Phine\Compact\Collection;
use Phine\Compact\CompactInterface;
use Phine\Compact\Php;
use Phine\Test\Property;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Performs unit testing on `Collection`.
 *
 * @see Phine\Compact\Collection
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class CollectionTest extends TestCase
{
    /**
     * The collection instance being tested.
     *
     * @var Collection
     */
    private $collection;

    /**
     * The compactor that will be used for testing.
     *
     * @var CompactInterface
     */
    private $compactor;

    /**
     * Make sure that we can add a compactor.
     */
    public function testAddCompactor()
    {
        $this->collection->addCompactor($this->compactor);

        $this->assertTrue(
            Property::get($this->collection, 'compactors')->contains($this->compactor),
            'The compactor should be added.'
        );
    }

    /**
     * Make sure that we can add compactors from another collection.
     */
    public function testAddCompactors()
    {
        $collection = new Collection();

        // inject a compactor
        Property::get($collection, 'compactors')->attach($this->compactor);

        $this->collection->addCompactors($collection);

        $this->assertTrue(
            Property::get($this->collection, 'compactors')->contains($this->compactor),
            'The compactors should have been added.'
        );
    }

    /**
     * Make sure that we can check if a compactor is added to the collection.
     */
    public function testHasCompactor()
    {
        $this->assertFalse(
            $this->collection->hasCompactor($this->compactor),
            'The compactor should not be in the collection.'
        );

        // inject a compactor
        Property::get($this->collection, 'compactors')->attach($this->compactor);

        $this->assertTrue(
            $this->collection->hasCompactor($this->compactor),
            'The compactor should be in the collection.'
        );
    }

    /**
     * Make sure that we can get a compactor in the collection.
     */
    public function testGetCompactor()
    {
        $this->assertNull(
            $this->collection->getCompactor('test'),
            'A compactor should not be returned.'
        );

        // inject a compactor
        Property::get($this->collection, 'compactors')->attach($this->compactor);

        $this->assertSame(
            $this->compactor,
            $this->collection->getCompactor('php'),
            'The same compactor should be returned.'
        );
    }

    /**
     * Make sure that we can get all of the compactors in the collection.
     */
    public function testGetCompactors()
    {
        // inject a compactor
        Property::get($this->collection, 'compactors')->attach($this->compactor);

        $this->assertSame(
            array($this->compactor),
            $this->collection->getCompactors(),
            'The compactors should be returned.'
        );
    }

    /**
     * Make sure that we can remove a compactor.
     */
    public function testRemoveCompactor()
    {
        // inject a compactor
        Property::get($this->collection, 'compactors')->attach($this->compactor);

        $this->collection->removeCompactor($this->compactor);

        $this->assertFalse(
            Property::get($this->collection, 'compactors')->contains($this->compactor),
            'The compactor should be removed from the collection..'
        );
    }

    /**
     * Make sure that we can replace the compactors of one collection with another.
     */
    public function testReplaceCompactors()
    {
        $collection = new Collection();
        $compactor = new Php();

        // inject a compactor
        Property::get($collection, 'compactors')->attach($compactor);
        Property::get($this->collection, 'compactors')->attach($this->compactor);

        $this->collection->replaceCompactors($collection);

        $this->assertFalse(
            Property::get($this->collection, 'compactors')->contains($this->compactor),
            'The compactors should have been removed.'
        );

        $this->assertTrue(
            Property::get($this->collection, 'compactors')->contains($compactor),
            'The compactors should have been added.'
        );
    }

    /**
     * Creates a new collection instance for testing.
     */
    protected function setUp()
    {
        $this->collection = new Collection();
        $this->compactor = new Php();
    }
}
