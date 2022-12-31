<?php

namespace tests\KoenVanMeijeren\ConvertToJUnitXML\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use KoenVanMeijeren\ConvertToJUnitXML\Command\ConvertBashGrepCommand;
use KoenVanMeijeren\ConvertToJUnitXML\Converters\Bash\Grep;

/**
 * Provides a class for ConvertGrepCommandTest.
 *
 * @package tests\KoenVanMeijeren\ConvertToJUnitXML\Command
 */
final class ConvertGrepCommandTest extends TestCase {
  private CommandTester $commandTester;

  protected function setUp(): void {
    $application = new Application();
    $application->add(new ConvertBashGrepCommand(new Grep()));

    $command = $application->find('convert:grep');
    $this->commandTester = new CommandTester($command);
  }

  public function testExecuteWithEmptyString(): void {
    $this->commandTester->execute(
          [
            'input' => '',
          ]
      );

    self::assertEquals(
          '<?xml version="1.0" encoding="utf-8"?>
<testsuites>
  <testsuite name="grep" failures="0"/>
</testsuites>
',
          $this->commandTester->getDisplay()
      );
    self::assertEquals(Command::SUCCESS, $this->commandTester->getStatusCode());
  }

  public function testExecuteReturnErrorCode(): void {
    $this->commandTester->execute(
          [
            'input' => file_get_contents(
                  __DIR__ . '/../assets/bash-grep/multiple.txt'
            ),
          ]
      );

    self::assertEquals(Command::FAILURE, $this->commandTester->getStatusCode());
  }

}
