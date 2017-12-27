<?php
/**
 * Simulation
 *
 * PHP Version 5.5
 *
 * @link      https://github.com/DannyvdSluijs/Simulation/
 * @copyright Copyright (c) 2016-2017
 * @license
 */

namespace WsdlToClass\Generator;

class TwigExtension extends \Twig_Extension
{
    public function getFilters(): array
    {
        return [
            new \Twig_SimpleFilter('lowerCamelCase', [$this, 'lowerCamelCase']),
            new \Twig_SimpleFilter('upperCamelCase', [$this, 'upperCamelCase']),
            new \Twig_SimpleFilter('camelCaseToWords', [$this, 'camelCaseToWords']),
            new \Twig_SimpleFilter('toPhpSupportedScalar', [$this, 'toPhpSupportedScalar']),
        ];
    }

    public function lowerCamelCase(string $name): string
    {
        return lcfirst($name);
    }

    public function upperCamelCase(string $name): string
    {
        return ucfirst($name);
    }

    public function camelCaseToWords(string $name): string
    {
        return trim(strtolower(preg_replace('/(?<!\ )[A-Z]/', ' $0', $name)));
    }

    /**
     * SOAP specification support scalar types that aren't supported or written differently by PHP
     * @param string $type
     * @return string
     */
    public function toPhpSupportedScalar(string $type): string
    {
        if ($type == 'short') {
            return 'float';
        }
        if ($type == 'double') {
            return 'float';
        }
        if ($type == 'boolean') {
            return 'bool';
        }

        return $type;
    }
}
