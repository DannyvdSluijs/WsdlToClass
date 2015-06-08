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
 * Description of Response
 *
 * @author Danny van der Sluijs <danny.vandersluijs@icloud.com>
 */
class Response extends Struct
{
    /**
     *
     * @param  IStructureGenerator $generator
     * @return string
     */
    public function visit(IStructureGenerator $generator)
    {
        return $generator->generateStruct($this);
    }
}
