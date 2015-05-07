<?php

namespace WsdlToClass\Parser;

class PhpInternalStructParser implements IParser
{
    const STRUCT = '/^struct (?P<name>\w*) {(?P<properties>(\n\s\w*\s\w*;)*)\n}$/';
    const PROPERTY = '/(?P<type>\w*)\s(?P<name>\w*);/';

    /**
     *
     * @param type $input
     */
    public function parse($input)
    {
        $matches = $properties = array();
        if (\preg_match(self::STRUCT, trim($input), $matches)
            && \preg_match_all(self::PROPERTY, $matches['properties'], $properties)
        ) {
            $struct = new \WsdlToClass\Wsdl\Struct();
            $struct->setName($matches['name']);

            for ($x = 0, $max = count($properties['name']); $x < $max; $x++) {
                $struct->addProperty(new \WsdlToClass\Wsdl\Property($properties['name'][$x], $properties['type'][$x]));
            }

            return $struct;

        } else {
            throw new \Exception('Unable to parse input');
        }
    }
}