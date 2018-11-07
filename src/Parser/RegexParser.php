<?php
/**
 * WsdlToClass
 *
 * PHP Version 7.1
 *
 * @copyright 2015-2018 Danny van der Sluijs <danny.vandersluijs@icloud.com>
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU-GPL
 * @link      http://dannyvandersluijs.nl
 */

declare(strict_types=1);

namespace WsdlToClass\Parser;

use WsdlToClass\Wsdl\Struct;
use WsdlToClass\Wsdl\Property;
use WsdlToClass\Wsdl\Method;

/**
 * The regex parser uses regex to parse string to Struct or Method classes
 */
class RegexParser implements IParser
{
    const _FUNCTION = '/^(?P<out>\w*) (?P<name>\w*)\((?P<in>\w*) \$(?P<parameterName>\w*)\)$/';

    const STRUCT = '/^struct (?P<name>\w*) {(?P<properties>(\n\s[\w<>]*\s[\w-]*;)*)\n}$/';
    const PROPERTY = '/(?P<type>[\w<>]*)\s(?P<name>[\w-]*);/';

    const ARRAY_OF_COMPLEX_TYPE = '/^(?P<type>\w*) (?P<name>\w*)\[\]$/';

    const SIMPLE_TYPE = '/^(?P<type>\w*) (?P<name>\w*)$/';

    /* WSDL Types mapped to PHP types */
    const STRING_TYPES = ['<anyXML>'];
    const DATETIME_TYPES = ['dateTime'];

    /**
     * Parse a type from a string to a Struct
     * @param string $input
     * @return Struct|Property
     * @throws \Exception when the input cannot be properly parsed.
     */
    public function parseType(string $input)
    {
        $matches = $properties = array();
        if (\preg_match(self::STRUCT, trim($input), $matches)) {
            /* Optional parse properties of the struct, could be empty complex types */
            \preg_match_all(self::PROPERTY, $matches['properties'], $properties);

            $struct = new Struct();
            $struct->setName($matches['name']);

            for ($x = 0, $max = count($properties['name']); $x < $max; $x++) {
                $type = $this->convertWsdlTypeToPhpType($properties['type'][$x]);
                $name = $this->covertNameToPhpName($properties['name'][$x]);
                $struct->addProperty(new Property($name, $type));
            }

            return $struct;
        } elseif (\preg_match(self::ARRAY_OF_COMPLEX_TYPE, trim($input), $matches)) {
            $struct = new Struct();
            $struct->setName($matches['name']);
            $struct->addProperty(new Property($matches['type'], $matches['type'] . '[]'));
            return $struct;
        } elseif (\preg_match(self::SIMPLE_TYPE, trim($input), $matches)) {
            return new Property($matches['name'], $matches['type']);
        } else {
            throw new \Exception(sprintf('Unable to parse input [%s]', $input));
        }
    }

    /**
     * Parse the input from a string to a function
     * @param  string $input
     * @return Method
     * @throws \Exception
     */
    public function parseFunction(string $input): Method
    {
        $matches = array();
        if (\preg_match(self::_FUNCTION, trim($input), $matches)) {
            $method = new Method();
            $method->setName($matches['name'])
                ->setRequest($matches['in'])
                ->setResponse($matches['out']);

            return $method;
        } else {
            throw new \Exception(sprintf('Unable to parse input [%s]', $input));
        }
    }

    /**
     * @param string $wsdlType
     * @return string
     */
    private function convertWsdlTypeToPhpType(string $wsdlType): string
    {
        if (in_array($wsdlType, self::STRING_TYPES)) {
            return 'string';
        }
        if (in_array($wsdlType, self::DATETIME_TYPES)) {
            return '\DateTime';
        }

        return $wsdlType;
    }

    /**
     * @param string $name
     * @return string
     */
    private function covertNameToPhpName(string $name): string
    {
        $name = str_replace('-', ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);

        return $name;
    }
}
