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

namespace WsdlToClass\Generator;

use WsdlToClass\Wsdl\Wsdl;

/**
 * The IClassMapGenerator ensures that a classmap class can be generated.
 */
interface IClassMapGenerator
{
    /**
     * Generate a class map from an WSDL object
     * @param Wsdl $wsdl
     * @return string
     */
    public function generateClassMap(Wsdl $wsdl): string;

    /**
     * Get the namespace
     * @return string
     */
    public function getNamespace(): string;

    /**
     * Set the namespace
     * @param string $namespace
     * @return self
     */
    public function setNamespace(string $namespace);
}
