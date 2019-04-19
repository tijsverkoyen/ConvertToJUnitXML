<?php

namespace tests\TijsVerkoyen\ConvertToJUnitXML\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use TijsVerkoyen\ConvertToJUnitXML\Command\ConvertFromNPMAuditCommand;

class ConvertFromNPMAuditCommandTest extends TestCase
{
    /**
     * @var CommandTester
     */
    private $commandTester;

    protected function setUp(): void
    {
        $application = new Application();
        $application->add(new ConvertFromNPMAuditCommand());

        $command = $application->find('convert:from-npm-audit-json');
        $this->commandTester = new CommandTester($command);
    }

    public function testExecute()
    {
        $this->expectException(\RuntimeException::class);
        $this->commandTester->execute([]);
    }
}
