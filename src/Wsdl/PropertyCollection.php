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
 * The property collection is used to group all the properties in a single object
 */
class PropertyCollection extends ArrayCollection
{
    /**
     * PropertyCollection constructor.
     * @param Property[] ...$properties
     */
    public function __construct(Property ...$properties)
    {
        foreach ($properties as $property) {
            $this->add($property);
        }
    }

    /**
     * @param Property $property
     */
    public function add(Property $property)
    {
        $this->addItem($property->getName(), $property);
    }
}
