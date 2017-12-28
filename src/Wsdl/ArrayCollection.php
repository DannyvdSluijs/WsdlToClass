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

namespace WsdlToClass\Wsdl;

use IteratorAggregate;
use Countable;

/**
 * The array collection offers basic operations on an array collection
 */
abstract class ArrayCollection implements IteratorAggregate, Countable
{
    /**
     * @var mixed[]
     */
    protected $items = [];

    /**
     * @param string $name
     * @param $item
     */
    protected function addItem(string $name, $item)
    {
        $this->items[$name] = $item;
    }

    protected function removeItem(string $name): bool
    {
        if (!$this->has($name)) {
            return false;
        }

        unset($this->items[$name]);

        return true;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->items);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        if (!$this->has($name)) {
            throw new \RuntimeException('No request with name ' . $name . ' available');
        }

        return $this->items[$name];
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
