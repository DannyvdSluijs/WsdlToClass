<?php
/**
 * WsdlToClass
 *
 * PHP Version 7.0
 *
 * @copyright 2015-2017 Danny van der Sluijs <danny.vandersluijs@icloud.com>
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU-GPL
 * @link      http://dannyvandersluijs.nl
 */

namespace WsdlToClass\Generator;

use WsdlToClass\Wsdl\Struct;

/**
 * The IStructureGenerator ensures that teh structure classes can be generated
 */
interface IStructureGenerator
{
    /**
     * Generate a struct
     * @param Struct $struct
     * @return string
     */
    public function generateStruct(Struct $struct): string;

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
