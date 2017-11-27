<?php
/**
 * WsdlToClass
 *
 * PHP Version 5.6
 *
 * @copyright 2015 Danny van der Sluijs <danny.vandersluijs@icloud.com>
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU-GPL
 * @link      http://dannyvandersluijs.nl
 */

namespace WsdlToClassTest\Commands;

use WsdlToClass\Commands\GenerateCommand;

class GenerateCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \WsdlToClass\Commands\GenerateCommand::configure()
     * @covers \WsdlToClass\Commands\GenerateCommand::execute()
     */
    public function testExecute()
    {
        $command = new GenerateCommand();
        $input = $this->createMock('Symfony\Component\Console\Input\InputInterface');
        $output = $this->createMock('Symfony\Component\Console\Output\OutputInterface');

        $input->expects($this->atLeastOnce())
            ->method('getOption')
            ->willReturnMap([
                ['destination', sys_get_temp_dir()],
                ['namespace', 'DannyvdSluijs\WsdlToClass\PhpUnit'],
                ['template', 'default']
            ]);
        $input->expects($this->atLeastOnce())
            ->method('getArgument')
            ->willReturnMap([
                ['wsdl', 'http://ws.cdyne.com/ip2geo/ip2geo.asmx?WSDL']
            ]);

        $command->run($input, $output);
    }

    /**
     * @covers \WsdlToClass\Commands\GenerateCommand::configure()
     * @covers \WsdlToClass\Commands\GenerateCommand::execute()
     */
    public function testExecuteWithUnreadableDestination()
    {
        $command = new GenerateCommand();
        $input = $this->createMock('Symfony\Component\Console\Input\InputInterface');
        $output = $this->createMock('Symfony\Component\Console\Output\OutputInterface');

        $input->expects($this->atLeastOnce())
            ->method('getOption')
            ->willReturnMap([
                ['destination', '/some/random/directory/that/is/not/there'],
            ]);

        $this->expectException('Exception');
        $command->run($input, $output);
    }
}
