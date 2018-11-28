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

namespace WsdlToClass\Util\Printer;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * An adapter to make the Symfony output interface compatible with the printer output interface
 */
class SymfonyOutputBridge implements PrinterOutputInterface
{
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * SymfonyOutputBridge constructor.
     * @param OutputInterface $output
     */
    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * Write a buffer to the symfony output
     * @param string $buffer
     */
    public function write(string $buffer): void
    {
        $this->output->write($buffer);
    }

    /**
     * Write a buffer and a newline to the symfony output
     * @param string $buffer
     */
    public function writeln(string $buffer): void
    {
        $this->output->writeln($buffer);
    }
}
