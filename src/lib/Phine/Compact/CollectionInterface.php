<?php

namespace Phine\Compact;

/**
 * Defines how a collection class must be implemented.
 *
 * Summary
 * -------
 *
 * A class implementing `CollectionInterface` will be capable of managing a
 * collection of compactors. The collection itself can then be used to compact
 * contents and files using the compactors that have been added to the
 * collection.
 *
 * Starting
 * --------
 *
 * To create a new collection, you will need to create your own implementation
 * of `CollectionInterface`.
 *
 *     use Phine\Compact\CollectionInterface;
 *
 *     class Collection implements CollectionInterface
 *     {
 *         private $compactors = array();
 *
 *         public function addCompactor(CompactInterface $compact)
 *         {
 *             $this->compactors[spl_object_hash($compact)] = $compact;
 *         }
 *
 *         public function hasCompactor(CompactInterface $compact)
 *         {
 *             return isset($this->compactors[spl_object_hash($compact)]);
 *         }
 *
 *         public function getCompactor($extension)
 *         {
 *             foreach ($this->compactors as $compactor) {
 *                 if ($compactor->isSupported($extension)) {
 *                     return $compactor;
 *                 }
 *             }
 *         }
 *
 *         public function getCompactors()
 *         {
 *             return array_values($this->compactors);
 *         }
 *
 *         public function removeCompactor(CompactInterface $compact)
 *         {
 *             unset($this->compactors[spl_object_hash($compact)]);
 *         }
 *     }
 *
 * Alternatively, you may simply use the bundled `Collection` class.
 *
 * @author Kevin Herrera <kevin@herrera.io>
 */
interface CollectionInterface
{
    /**
     * Adds a compactor to the collection.
     *
     * This method will add a compactor to this collection. If the compactor
     * has already been added to this collection, it will not be added again.
     *
     *     use Phine\Compact\Json;
     *     use Phine\Compact\Php;
     *     use Phine\Compact\Xml;
     *
     *     $collection->addCompactor(new Json());
     *     $collection->addCompactor(new Php());
     *     $collection->addCompactor(new Xml());
     *
     * @param CompactInterface $compactor A compactor to add.
     */
    public function addCompactor(CompactInterface $compactor);

    /**
     * Adds the compactors from another collection.
     *
     * This method will add the compactors from another collection to this
     * one. If a compactor in the other collection is already in this one,
     * it will be ignored and the remaining compactors will be added.
     *
     *     $collection->addCompactors($anotherCollection);
     *
     * @param CollectionInterface $collection A collection of compactors.
     */
    public function addCompactors(CollectionInterface $collection);

    /**
     * Checks if the collection has a compactor.
     *
     * This method will check if a given compactor instance has been added to
     * this collection. If the compactor has not been added to this collection,
     * `false` is returned.
     *
     *     if ($collection->hasCompactor($compactor)) {
     *         // in the collection
     *     }
     *
     * @param CompactInterface $compactor A compactor to check for.
     *
     * @return boolean If the compactor is in the collection, `true` is
     *                 returned. If the compactor is not in the collection,
     *                 `false` is returned.
     */
    public function hasCompactor(CompactInterface $compactor);

    /**
     * Returns the compactor for a file extension.
     *
     * This method will search the collection for a compactor that supports
     * the given file extension. If one is found, it will be returned. If no
     * compactor is found nothing (`null`) is returned.
     *
     * @param string $extension A file extension.
     *
     * @return CompactInterface The compactor.
     */
    public function getCompactor($extension);

    /**
     * Returns a list of the compactors in this collection.
     *
     * This method will return all of the compactors that have been added to
     * this collection. If no compactors have been added, an empty array will
     * be returned.
     *
     *     $compactors = $collection->getCompactors();
     *
     * @return CompactInterface[] A list of compactors.
     */
    public function getCompactors();

    /**
     * Removes a compactor from this collection.
     *
     * This method will remove a given compactor from this collection.
     *
     *     $collection->removeCompactor($compactor);
     *
     * @param CompactInterface $compactor A compactor to remove.
     */
    public function removeCompactor(CompactInterface $compactor);

    /**
     * Replaces the compactors using another collection.
     *
     * This method will replace the compactors of this collection with the ones
     * added to the given collection. Any compactors that were previously added
     * to this collection may be lost if it is not present in the given
     * collection.
     *
     * @param CollectionInterface $collection A collection of compactors.
     */
    public function replaceCompactors(CollectionInterface $collection);
}
