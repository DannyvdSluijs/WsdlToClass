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
 * Description of Struct
 *
 * @author dannyvandersluijs
 */
class Property
{
    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @var string
     */
    private $type;

    /**
     *
     * @param string $name
     * @param string $type
     */
    public function __construct($name = null, $type = null)
    {
        $this->name = !is_null($name) ? (string) $name : null;
        $this->type = !is_null($type) ? (string) $type : null;
    }

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
     * @param  string                     $name
     * @return \WsdlToClass\Wsdl\Property
     */
    public function setName($name)
    {
        $this->name = (string) $name;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     *
     * @param  string                     $type
     * @return \WsdlToClass\Wsdl\Property
     */
    public function setType($type)
    {
        $this->type = (string) $type;

        return $this;
    }
}
