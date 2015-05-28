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
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

use WsdlToClass\WsdlToClass;
use WsdlToClass\Wsdl\Wsdl;
use WsdlToClass\Parser\RegexParser;

class ImportCommand extends Command {

    protected function configure()
    {
        $this
            ->setName("wsdltoclass:import")
             ->setDescription("Import a WSDL to output classes")
             ->setDefinition(array(
                new InputArgument('wsdl', InputArgument::REQUIRED, 'The wsdl to import', null),
                new InputOption('output', 'o', InputOption::VALUE_REQUIRED, 'The output directory', getcwd()),
                new InputOption('namespace', 'ns', InputOption::VALUE_OPTIONAL, 'An optional namespace', getcwd()),
            ))
             ->setHelp(<<<EOT
Usage:

<info>./run.php wdltoclass:import http://www.url.com/wsdl</info>
EOT
);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!is_readable($input->getOption('output'))) {
            throw new \Exception(sprintf('Unable to read output directory [%s]', $input->getOption('output')));
        }

        $wsdlToClass = new WsdlToClass(
            new Wsdl($input->getArgument('wsdl')),
            $input->getOption('output'),
            $input->getOption('namespace'),
            new RegexParser()
        );
        $wsdlToClass->execute();
    }
}
