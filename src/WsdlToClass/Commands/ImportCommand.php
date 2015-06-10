<?php
/**
 * wsdlToClass
 *
 * PHP Version 5.3
 *
 * @copyright 2015 Danny van der Sluijs <dammy.vandersluijs@icloud.com>
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU-GPL
 * @link      http://dannyvandersluijs.nl
 */
namespace WsdlToClass\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use WsdlToClass\WsdlToClass;
use WsdlToClass\Wsdl\Wsdl;
use WsdlToClass\Parser\RegexParser;
use WsdlToClass\Generator\Generator;
use WsdlToClass\Writer\ResourceWriter;

/**
 * The import commands takes a wsdl and generates a set of php classes which can be utilised
 * to implement the WSDL for either server or client implemetation.
 *
 * @author Danny van der Sluijs <danny.vandersluijs@icloud.com>
 */
class ImportCommand extends Command
{
    /**
     * Configure the import command
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName("wsdltoclass:import")
             ->setDescription("Import a WSDL to output classes")
             ->setDefinition(array(
                new InputArgument('wsdl', InputArgument::REQUIRED, 'The wsdl to import', null),
                new InputOption('destination', 'd', InputOption::VALUE_REQUIRED, 'The destination directory', getcwd()),
                new InputOption('namespace', null, InputOption::VALUE_OPTIONAL, 'An optional namespace'),
            ))
             ->setHelp(<<<EOT
Usage:

<info>./run.php wdltoclass:import http://www.url.com/wsdl</info>
EOT
);
    }

    /**
     * Execute the import command
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!is_readable($input->getOption('destination'))) {
            throw new \Exception(sprintf('Unable to read output directory [%s]', $input->getOption('destination')));
        }

        $wsdlToClass = new WsdlToClass(
            new Wsdl($input->getArgument('wsdl')),
            $input->getOption('destination'),
            $input->getOption('namespace'),
            new RegexParser(),
            new Generator(),
            new ResourceWriter()
        );

        $wsdlToClass->setOutput($output)->execute();
    }
}
