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
 * Description of Response
 *
 * @author dannyvandersluijs
 */
class Response
{
    public function visit(IModelGenerator $generator)
    {
        return $generator->generate($this);
    }
}
