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
namespace WsdlToClass\Parser;

/**
 * The IParser interface ensures that types and functions can be parsed.
 * @author Danny van der Sluijs <danny.vandersluijs@icloud.com>
 */
interface IParser
{
    /**
     * Parse a SOAP type into a Property
     * @param  string                     $input
     * @return \WsdlToClass\Wsdl\Struct
     */
    public function parseType($input);

    /**
     * Parse a SOAP function into a Method
     * @param  string                   $input
     * @return \WsdlToClass\Wsdl\Method
     */
    public function parsefunction($input);
}
