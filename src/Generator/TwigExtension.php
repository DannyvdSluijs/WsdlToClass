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
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('lowerCamelCase', [$this, 'lowerCamelCase']),
        ];
    }

    public function lowerCamelCase($name)
    {
        $name = lcfirst($name);

        return $name;
    }
}
