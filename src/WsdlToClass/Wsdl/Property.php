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

/**
 * A WSDL property is a class representation of an WSDL type both simple as complex.
 *
 * @author Danny van der Sluijs <danny.vandersluijs@icloud.com>
 */
class Property implements IWsdlNode
{
    /**
     * The name of the property
     * @var string
     */
    private $name;

    /**
     * The type of the property
     * @var string
     */
    private $type;

    /**
     * Construct a property, optionally with name and type.
     * @param string $name
     * @param string $type
     */
    public function __construct($name = null, $type = null)
    {
        $this->name = !is_null($name) ? (string) $name : null;
        $this->type = !is_null($type) ? (string) $type : null;
    }

    /**
     * Get the name of the property
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name of the property
     * @param  string                     $name
     * @return \WsdlToClass\Wsdl\Property
     */
    public function setName($name)
    {
        $this->name = (string) $name;

        return $this;
    }

    /**
     * Get the type of the property
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the type of the property
     * @param  string                     $type
     * @return \WsdlToClass\Wsdl\Property
     */
    public function setType($type)
    {
        $this->type = (string) $type;

        return $this;
    }
}
