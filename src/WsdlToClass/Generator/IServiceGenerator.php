<?php

/*
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
 *
 * @author dannyvandersluijs
 */
interface IServiceGenerator
{
    /**
     * Generate a service class from a WSDL object
     * @param Wsdl $wsdl
     */
    public function generateService(Wsdl $wsdl);
}
