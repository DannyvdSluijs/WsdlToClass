<?php
/**
 * WsdlToClass
 *
 * PHP Version 7.1
 *
 * @copyright 2015-2018 Danny van der Sluijs <danny.vandersluijs@icloud.com>
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU-GPL
 * @link      http://dannyvandersluijs.nl
 */

declare(strict_types=1);

namespace WsdlToClass\Wsdl;

use WsdlToClass\Generator\IStructureGenerator;

/**
 * A Struct is a class representation of complex type in the wsdl.
 */
class Struct implements IWsdlNode
{
    /**
     * The name of the Struct
     * @var string
     */
    private $name = '';

    /**
     * The properties of the Struct
     * @var Property[]
     */
    private $properties = [];

    /**
     * Get the name of the Struct
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the name of the struct
     * @param  string $name
     * @return \WsdlToClass\Wsdl\Struct
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the properties fo the Struct
     * @return \WsdlToClass\Wsdl\Property[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Set the properties of the Struct
     * @param  \WsdlToClass\Wsdl\Property[] $properties
     * @return \WsdlToClass\Wsdl\Struct
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * Add a single Property to the Struct
     * @param  \WsdlToClass\Wsdl\Property $property
     * @return \WsdlToClass\Wsdl\Struct
     */
    public function addProperty(Property $property)
    {
        $this->properties[$property->getName()] = $property;

        return $this;
    }

    /**
     * Get a single property of the Struct
     * @param  string $name
     * @return Property
     */
    public function getProperty($name)
    {
        if ($this->hasProperty($name)) {
            return $this->properties[$name];
        }
    }

    /**
     * Test if the Struct has a named Property
     * @param  string $name
     * @return boolean
     */
    public function hasProperty($name)
    {
        return array_key_exists($name, $this->properties);
    }

    /**
     * Visit the Struct with a IStructureGenerator
     * @param  IStructureGenerator $generator
     * @return string
     */
    public function visit(IStructureGenerator $generator)
    {
        return $generator->generateStruct($this);
    }
}
