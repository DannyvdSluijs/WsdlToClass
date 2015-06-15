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
use WsdlToClass\Generator\TwigGenerator;
use WsdlToClass\Writer\ResourceWriter;

/**
 * The generate commands takes a wsdl and generates a set of php classes which can be utilised
 * to implement the WSDL for either server or client implemetation.
 *
 * @author Danny van der Sluijs <danny.vandersluijs@icloud.com>
 */
class GenerateCommand extends Command
{
    /**
     * Configure the generate command
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName("wsdltoclass:generate")
             ->setDescription("Transform a WSDL to PHP classes")
             ->setDefinition(array(
                new InputArgument('wsdl', InputArgument::REQUIRED, 'The wsdl to generate', null),
                new InputOption('destination', 'd', InputOption::VALUE_REQUIRED, 'The destination directory', getcwd()),
                new InputOption('namespace', null, InputOption::VALUE_REQUIRED, 'An optional namespace', 'Soap'),
            ))
             ->setHelp(<<<EOT
Usage:

<info>./run.php wdltoclass:generate http://www.url.com/wsdl</info>
EOT
);
    }

    /**
     * Execute the generate command
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
            new TwigGenerator(),
            new ResourceWriter()
        );

        $wsdlToClass->setOutput($output)->execute();
    }
}
