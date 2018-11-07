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

namespace WsdlToClass\Util;

use WsdlToClass\Util\Printer\PrinterOutputInterface;

/**
 * The printer class can be used as a utility for printing output
 */
class Printer
{
    /**
     * The outout strategy
     * @var PrinterOutputInterface
     */
    private $output;

    /**
     * Printer constructor.
     * @param PrinterOutputInterface $output
     */
    public function __construct(PrinterOutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * Write a buffer to the output
     * @param string $buffer
     */
    public function write(string $buffer)
    {
        $this->output->write($buffer);
    }

    /**
     * Write a buffer and a newline to the output
     * @param string $buffer
     */
    public function writeln(string $buffer)
    {
        $this->output->writeln($buffer);
    }
}
