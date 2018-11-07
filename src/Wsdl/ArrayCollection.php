<?php
/**
 * WsdlToClass
 *
 * PHP Version 7.0
 *
 * @copyright 2015-2017 Danny van der Sluijs <danny.vandersluijs@icloud.com>
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU-GPL
 * @link      http://dannyvandersluijs.nl
 */

declare(strict_types=1);

namespace WsdlToClass\Wsdl;

use IteratorAggregate;
use Countable;

/**
 * The array collection offers basic operations on an array collection
 */
abstract class ArrayCollection implements IteratorAggregate, Countable
{
    /**
     * A collection of items
     * @var mixed[]
     */
    protected $items = [];

    /**
     * Add an item to the array collection
     * @param string $key
     * @param mixed $item
     */
    protected function addItem(string $key, $item)
    {
        $this->items[$key] = $item;
    }

    /**
     * Remove an item from the array collection by its key
     * @param string $key
     * @return bool Returns true if item was removed
     */
    protected function removeItem(string $key): bool
    {
        if (!$this->has($key)) {
            return false;
        }

        unset($this->items[$key]);

        return true;
    }

    /**
     * See if a item is available in the collection by its key
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * Get an item from the collection by its key
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        if (!$this->has($key)) {
            throw new \RuntimeException('No item with name ' . $key . ' available');
        }

        return $this->items[$key];
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->items);
    }
}
