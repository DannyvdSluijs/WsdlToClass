<?php

namespace WsdlToClass\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class ImportCommand extends Command {

    protected function configure()
    {
        $this->setName("wsdltoclass:import")
             ->setDescription("Import a WSDL to output classes")
             ->setDefinition(array(
                      new InputOption('wsdl', 'w', InputOption::VALUE_REQUIRED, 'The wsdl to import', $start),
                ))
             ->setHelp(<<<EOT
Usage:

<info>./run.php wdltoclass:import http://www.url.com/wsdl</info>
EOT
);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $parser = new \WsdlToClass\Parser\PhpInternalStructParser();

        var_dump($parser instanceof \WsdlToClass\Parser\IParser);
        return;
    }
}
