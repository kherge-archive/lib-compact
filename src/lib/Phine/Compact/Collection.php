<?php

namespace Phine\Compact;

use SplObjectStorage;

/**
 * Manages a collection of compactors.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
class Collection implements CollectionInterface
{
    /**
     * The collection of compactors.
     *
     * @var CompactInterface[]|SplObjectStorage
     */
    private $compactors;

    /**
     * Initializes the collection of compactors.
     */
    public function __construct()
    {
        $this->compactors = new SplObjectStorage();
    }

    /**
     * {@inheritDoc}
     */
    public function addCompactor(CompactInterface $compact)
    {
        $this->compactors->attach($compact);
    }

    /**
     * {@inheritDoc}
     */
    public function addCompactors(CollectionInterface $collection)
    {
        foreach ($collection->getCompactors() as $compactor) {
            $this->compactors->attach($compactor);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function hasCompactor(CompactInterface $compact)
    {
        return $this->compactors->contains($compact);
    }

    /**
     * {@inheritDoc}
     */
    public function getCompactor($extension)
    {
        foreach ($this->compactors as $compactor) {
            if ($compactor->isSupported($extension)) {
                return $compactor;
            }
        }

        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getCompactors()
    {
        $compactors = array();

        foreach ($this->compactors as $compactor) {
            $compactors[] = $compactor;
        }

        return $compactors;
    }

    /**
     * {@inheritDoc}
     */
    public function removeCompactor(CompactInterface $compactor)
    {
        $this->compactors->detach($compactor);
    }

    /**
     * {@inheritDoc}
     */
    public function replaceCompactors(CollectionInterface $collection)
    {
        $this->compactors = new SplObjectStorage();

        $this->addCompactors($collection);
    }
}
