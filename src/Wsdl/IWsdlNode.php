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

namespace WsdlToClass\Wsdl;

/**
 *
 */
interface IWsdlNode
{
    /**
     * Get the name of the Wsdl Node
     */
    public function getName(): string;

    /**
     * Set the name of the Wsdl Node
     * @param string $name
     */
    public function setName(string $name): void;
}
