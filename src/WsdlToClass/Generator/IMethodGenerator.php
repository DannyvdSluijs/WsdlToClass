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

use WsdlToClass\Wsdl\Method;
/**
 * The IMethodGenerator ensures that the method classes can be generated
 * @author Danny van der Sluijs <danny.vandersluijs@icloud.com>
 */
interface IMethodGenerator
{
    /**
     * Generate a method class from a mathod
     * @param Method $method
     */
    public function generateMethod(Method $method);
}
