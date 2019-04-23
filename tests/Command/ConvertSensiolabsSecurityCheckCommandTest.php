<?php

namespace tests\TijsVerkoyen\ConvertToJUnitXML\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use TijsVerkoyen\ConvertToJUnitXML\Command\ConvertSensiolabsSecurityCheckCommand;
use TijsVerkoyen\ConvertToJUnitXML\Converters\Sensiolabs\SecurityCheck;

class ConvertSensiolabsSecurityCheckCommandTest extends TestCase
{
    /**
     * @var CommandTester
     */
    private $commandTester;

    protected function setUp(): void
    {
        $application = new Application();
        $application->add(
            new ConvertSensiolabsSecurityCheckCommand(new SecurityCheck())
        );

        $command = $application->find('convert:sensiolabs-security-check');
        $this->commandTester = new CommandTester($command);
    }

    public function testExecuteWithEmptyJson()
    {
        $this->commandTester->execute(
            [
                'input' => '{}'
            ]
        );

        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?>
<testsuites/>
',
            $this->commandTester->getDisplay()
        );
        $this->assertEquals(0, $this->commandTester->getStatusCode());
    }
}
