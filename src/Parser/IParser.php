<?php
/**
 * WsdlToClass
 *
 * PHP Version 7.1
 *
 * @copyright 2015-2017 Danny van der Sluijs <danny.vandersluijs@icloud.com>
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU-GPL
 * @link      http://dannyvandersluijs.nl
 */

declare(strict_types=1);

namespace WsdlToClass\Parser;

use WsdlToClass\Wsdl\Method;
use WsdlToClass\Wsdl\Property;
use WsdlToClass\Wsdl\Struct;

/**
 * The IParser interface ensures that types and functions can be parsed.
 */
interface IParser
{
    /**
     * Parse a SOAP type into a Property
     * @param  string $input
     * @return Struct|Property
     */
    public function parseType(string $input);

    /**
     * Parse a SOAP function into a Method
     * @param  string $input
     * @return Method
     */
    public function parseFunction(string $input): Method;
}
