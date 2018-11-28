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
     * Struct constructor.
     * @param string $name
     * @param array $properties
     */
    public function __construct(string $name = '', array $properties = [])
    {
        $this->name = $name;
        $this->properties = $properties;
    }

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
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get the properties fo the Struct
     * @return \WsdlToClass\Wsdl\Property[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * Set the properties of the Struct
     * @param  \WsdlToClass\Wsdl\Property[] $properties
     */
    public function setProperties(array $properties): void
    {
        $this->properties = $properties;
    }

    /**
     * Add a single Property to the Struct
     * @param  \WsdlToClass\Wsdl\Property $property
     */
    public function addProperty(Property $property): void
    {
        $this->properties[$property->getName()] = $property;
    }

    /**
     * Get a single property of the Struct
     * @param  string $name
     * @return Property|null
     */
    public function getProperty($name): ?Property
    {
        if ($this->hasProperty($name)) {
            return $this->properties[$name];
        }

        return null;
    }

    /**
     * Test if the Struct has a named Property
     * @param  string $name
     * @return boolean
     */
    public function hasProperty($name): bool
    {
        return array_key_exists($name, $this->properties);
    }

    /**
     * Visit the Struct with a IStructureGenerator
     * @param  IStructureGenerator $generator
     * @return string
     */
    public function visit(IStructureGenerator $generator): string
    {
        return $generator->generateStruct($this);
    }
}
