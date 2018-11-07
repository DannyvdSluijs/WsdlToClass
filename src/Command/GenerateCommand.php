<?php
/**
 * WsdlToClass
 *
 * PHP Version 7.1
 *
 * @copyright 2015-2017 Danny van der Sluijs <danny.vandersluijs@icloud.com>
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU-GPL
 * @link      http://dannyvandersluijs.nl
 */

declare(strict_types=1);

namespace WsdlToClass\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use WsdlToClass\Util\Printer;
use WsdlToClass\WsdlToClass;
use WsdlToClass\Wsdl\Wsdl;
use WsdlToClass\Parser\RegexParser;
use WsdlToClass\Generator\TwigGenerator;
use WsdlToClass\Writer\ResourceWriter;

/**
 * The generate commands takes a wsdl and generates a set of php classes which can be utilised
 * to implement the WSDL for either server or client implementation.
 */
class GenerateCommand extends Command
{
    /**
     * Configure the generate command
     * @return void
     */
    protected function configure()
    {
        $this->setName("wsdltoclass:generate")
             ->setDescription("Transform a WSDL to PHP classes")
             ->setDefinition([
                new InputArgument('wsdl', InputArgument::REQUIRED, 'The wsdl to generate, filepath or url', null),
                new InputOption('destination', 'd', InputOption::VALUE_REQUIRED, 'The destination directory', getcwd()),
                new InputOption('namespace', null, InputOption::VALUE_REQUIRED, 'An optional namespace', 'Soap'),
                new InputOption('template', null, InputOption::VALUE_OPTIONAL, ' Name of the template to use (optional)', 'default'),
             ])
             ->setHelp(<<<EOT
Usage:

<info>./run.php wsdltoclass:generate http://www.url.com/wsdl</info>
EOT
        );
    }

    /**
     * Execute the generate command
     * @param  InputInterface $input
     * @param  OutputInterface $output
     * @return void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $destination = (string) $input->getOption('destination');

        if (!is_readable(dirname($destination))
            || !is_readable($destination) && !mkdir($destination, 0755, true)
        ) {
            throw new \Exception(sprintf('Unable to read output directory [%s]', $destination));
        }

        $wsdlToClass = new WsdlToClass(
            new Wsdl((string) $input->getArgument('wsdl')),
            $destination,
            (string) $input->getOption('namespace'),
            new RegexParser(),
            new TwigGenerator($input->getOption('template')),
            new ResourceWriter(),
            new Printer(new Printer\SymfonyOutputBridge($output))
        );

        $wsdlToClass->execute();
    }
}
