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

/**
 * The struct collection is used to group all the structs in a single object
 */
class StructCollection extends ArrayCollection
{
    /**
     * StructCollection constructor.
     * @param Struct[] ...$structs
     */
    public function __construct(Struct ...$structs)
    {
        foreach ($structs as $struct) {
            $this->add($struct);
        }
    }

    /**
     * @param Struct $struct
     */
    public function add(Struct $struct)
    {
        $this->addItem($struct->getName(), $struct);
    }

    public function remove(Struct $struct): bool
    {
        return $this->removeItem($struct->getName());
    }
}
