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

use WsdlToClass\Generator\IStructureGenerator;

/**
 * Description of Struct
 *
 * @author dannyvandersluijs
 */
class Struct
{
    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @var Property[]
     */
    private $properties = array();

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param  string                   $name
     * @return \WsdlToClass\Wsdl\Struct
     */
    public function setName($name)
    {
        $this->name = (string) $name;

        return $this;
    }

    /**
     *
     * @return type
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     *
     * @param  array                    $properties
     * @return \WsdlToClass\Wsdl\Struct
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     *
     * @param  \WsdlToClass\Wsdl\Property $property
     * @return \WsdlToClass\Wsdl\Struct
     */
    public function addProperty(Property $property)
    {
        $this->properties[$property->getName()] = $property;

        return $this;
    }

    /**
     *
     * @param  type $name
     * @return type
     */
    public function getProperty($name)
    {
        if ($this->hasProperty($name)) {
            return $this->properties[$name];
        }
    }

    /**
     *
     * @param  type $name
     * @return type
     */
    public function hasProperty($name)
    {
        return array_key_exists($name, $this->properties);
    }

    /**
     *
     * @param  IStructureGenerator $generator
     * @return type
     */
    public function visit(IStructureGenerator $generator)
    {
        return $generator->generateStruct($this);
    }
}
