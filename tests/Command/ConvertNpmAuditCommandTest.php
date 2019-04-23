<?php

namespace tests\TijsVerkoyen\ConvertToJUnitXML\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use TijsVerkoyen\ConvertToJUnitXML\Command\ConvertNpmAuditCommand;
use TijsVerkoyen\ConvertToJUnitXML\Converters\Npm\Audit;

class ConvertNpmAuditCommandTest extends TestCase
{
    /**
     * @var CommandTester
     */
    private $commandTester;

    protected function setUp(): void
    {
        $application = new Application();
        $application->add(new ConvertNpmAuditCommand(new Audit()));

        $command = $application->find('convert:npm-audit');
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
<testsuites>
  <testsuite name="npm audit" failures="0"/>
</testsuites>
',
            $this->commandTester->getDisplay()
        );
        $this->assertEquals(0, $this->commandTester->getStatusCode());
    }

    public function testExecuteReturnErrorCode()
    {
        $this->commandTester->execute(
            [
                'input' => file_get_contents(
                    __DIR__ . '/../assets/npm-audit/multiple.json'
                ),
            ]
        );

        $this->assertEquals(1, $this->commandTester->getStatusCode());
    }
}
