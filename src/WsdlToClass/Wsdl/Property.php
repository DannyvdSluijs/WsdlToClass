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
    private $name;

    private $type;

    public function __construct($name, $type)
    {
        $this->name = (string) $name;
        $this->type = (string) $type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = (string) $name;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = (string) $type;
        return $this;
    }
}
