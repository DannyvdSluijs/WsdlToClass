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

namespace WsdlToClass\Generator;

use WsdlToClass\Wsdl\Wsdl;

/**
 * The IClassMapGenerator ensures that a classmap class can be generated.
 * @author Danny van der Sluijs <danny.vandersluijs@icloud.com>
 */
interface IClassMapGenerator
{
    /**
     * Generate a class map from an WSDL object
     * @param Wsdl $wsdl
     */
    public function generateClassMap(Wsdl $wsdl);
}
