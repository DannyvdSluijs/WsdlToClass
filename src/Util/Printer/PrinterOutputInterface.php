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

namespace WsdlToClass\Util\Printer;

/**
 * An interface defining the contract
 */
interface PrinterOutputInterface
{
    /**
     * Write a buffer to the output
     * @param string $buffer
     */
    public function write(string $buffer);

    public function writeln(string $buffer);
}
