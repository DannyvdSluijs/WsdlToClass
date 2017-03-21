<?php

/**
 * WsdlToClass
 *
 * PHP Version 5.6
 *
 * @copyright 2015 Danny van der Sluijs <danny.vandersluijs@icloud.com>
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU-GPL
 * @link      http://dannyvandersluijs.nl
 */

namespace WsdlToClass\Generator;

use WsdlToClass\Wsdl\Wsdl;

/**
 * The IServiceGenerator ensures that a service class can be generated
 * @author Danny van der Sluijs <danny.vandersluijs@icloud.com>
 */
interface IServiceGenerator
{
    /**
     * Generate a service class from a WSDL object
     * @param Wsdl $wsdl
     */
    public function generateService(Wsdl $wsdl);

    /**
     * Get the namespace
     * @return string
     */
    public function getNamespace();
}
