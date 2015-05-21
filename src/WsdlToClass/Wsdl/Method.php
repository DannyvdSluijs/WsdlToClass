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
 * Description of Mathod
 *
 * @author dannyvandersluijs
 */
class Method
{
    private $name;

    private $return;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getReturn()
    {
        return $this->return;
    }

    public function setReturn($return)
    {
        $this->return = $return;
        return $this;
    }

    public function visit(IModelGenerator $generator)
    {
    }
}
