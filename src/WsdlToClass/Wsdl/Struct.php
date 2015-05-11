<?php

/**
 * wsdlToClass
 *
 * PHP Version 5.3
 *
 * @copyright 2015 Danny van der Sluijs <dammy.vandersluijs@icloud.com>
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU-GPL
 * @link      http://dannyvandersluijs.nl
 */

namespace WsdlToClass\Wsdl;

use WsdlToClass\Generator\IModelGenerator;

/**
 * Description of Struct
 *
 * @author dannyvandersluijs
 */
class Struct
{
    private $name;

    private $properties;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function setProperties($properties)
    {
        $this->properties = $properties;
        return $this;
    }

    public function addProperty(Property $property)
    {
        $this->properties[$property->getName()] = $property;
    }

    public function getProperty($name)
    {
        if ($this->hasProperty($name)) {
            return $this->properties[$name];
        }
    }

    public function hasProperty($name)
    {
        return array_key_exists($name, $this->properties);
    }

    public function visit(IModelGenerator $generator)
    {
        return $generator->generate($this);
    }
}
