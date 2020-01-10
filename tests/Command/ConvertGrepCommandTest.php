<?php

namespace tests\TijsVerkoyen\ConvertToJUnitXML\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use TijsVerkoyen\ConvertToJUnitXML\Command\ConvertBashGrepCommand;
use TijsVerkoyen\ConvertToJUnitXML\Converters\Bash\Grep;

class ConvertGrepCommandTest extends TestCase
{
    /**
     * @var CommandTester
     */
    private $commandTester;

    protected function setUp(): void
    {
        $application = new Application();
        $application->add(new ConvertBashGrepCommand(new Grep()));

        $command = $application->find('convert:grep');
        $this->commandTester = new CommandTester($command);
    }

    public function testExecuteWithEmptyString()
    {
        $this->commandTester->execute(
            [
                'input' => ''
            ]
        );

        $this->assertEquals(
            '<?xml version="1.0" encoding="utf-8"?>
<testsuites>
  <testsuite name="grep" failures="0"/>
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
                    __DIR__ . '/../assets/bash-grep/multiple.txt'
                ),
            ]
        );

        $this->assertEquals(1, $this->commandTester->getStatusCode());
    }
}
