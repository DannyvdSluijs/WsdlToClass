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

class RegexParser implements IParser
{
    const _FUNCTION = '/^(?P<out>\w*) (?P<name>\w*)\((?P<in>\w*) \$(?P<parameterName>\w*)\)$/';

    const STRUCT = '/^struct (?P<name>\w*) {(?P<properties>(\n\s\w*\s\w*;)*)\n}$/';
    const PROPERTY = '/(?P<type>\w*)\s(?P<name>\w*);/';

    /**
     *
     * @param string $input
     */
    public function parseType($input)
    {
        $matches = $properties = array();
        if (\preg_match(self::STRUCT, trim($input), $matches)) {

            /* Optional parse properties of the struct, could be empty complex types */
            \preg_match_all(self::PROPERTY, $matches['properties'], $properties);

            $struct = new \WsdlToClass\Wsdl\Struct();
            $struct->setName($matches['name']);

            for ($x = 0, $max = count($properties['name']); $x < $max; $x++) {
                $struct->addProperty(new \WsdlToClass\Wsdl\Property($properties['name'][$x], $properties['type'][$x]));
            }

            return $struct;
        } else {
            throw new \Exception(sprintf('Unable to parse input [%s]', $input));
        }
    }

    /**
     *
     * @param  string                   $input
     * @return \WsdlToClass\Wsdl\Method
     * @throws \Exception
     */
    public function parseFunction($input)
    {
        $matches = array();
        if (\preg_match(self::_FUNCTION, trim($input), $matches)) {
            $method = new \WsdlToClass\Wsdl\Method();
            $method
                ->setName($matches['name'])
                ->setRequest($matches['in'])
                ->setResponse($matches['out']);

            return $method;
        } else {
            throw new \Exception(sprintf('Unable to parse input [%s]', $input));
        }
    }
}
