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
 * A WSDL property is a class representation of an WSDL type both simple as complex.
 */
class Property implements IWsdlNode
{
    /**
     * The name of the property
     * @var string
     */
    private $name = '';

    /**
     * The type of the property
     * @var string
     */
    private $type = '';

    /**
     * Construct a property, optionally with name and type.
     * @param string $name
     * @param string $type
     */
    public function __construct(string $name = null, string $type = null)
    {
        $this->name = !is_null($name) ? $name : '';
        $this->type = !is_null($type) ? $type : '';
    }

    /**
     * Get the name of the property
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the name of the property
     * @param  string $name
     * @return self
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the type of the property
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set the type of the property
     * @param  string $type
     * @return self
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }
}
