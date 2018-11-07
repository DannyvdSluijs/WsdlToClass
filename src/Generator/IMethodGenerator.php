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

declare(strict_types=1);

namespace WsdlToClass\Generator;

use WsdlToClass\Wsdl\Method;

/**
 * The IMethodGenerator ensures that the method classes can be generated
 */
interface IMethodGenerator
{
    /**
     * Generate a method class from a mathod
     * @param Method $method
     * @return string
     */
    public function generateMethod(Method $method): string;

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
