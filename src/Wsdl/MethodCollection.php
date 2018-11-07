<?php
/**
 * WsdlToClass
 *
 * PHP Version 7.1
 *
 * @copyright 2015-2017 Danny van der Sluijs <danny.vandersluijs@icloud.com>
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU-GPL
 * @link      http://dannyvandersluijs.nl
 */

declare(strict_types=1);

namespace WsdlToClass\Wsdl;

/**
 * The method collection is used to group all the methods in a single object
 */
class MethodCollection extends ArrayCollection
{
    /**
     * MethodCollection constructor.
     * @param Method[] ...$methods
     */
    public function __construct(Method ...$methods)
    {
        foreach ($methods as $method) {
            $this->add($method);
        }
    }

    /**
     * @param Method $method
     */
    public function add(Method $method)
    {
        parent::addItem($method->getName(), $method);
    }
}
