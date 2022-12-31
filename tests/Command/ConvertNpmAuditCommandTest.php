<?php

namespace tests\KoenVanMeijeren\ConvertToJUnitXML\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use KoenVanMeijeren\ConvertToJUnitXML\Command\ConvertNpmAuditCommand;
use KoenVanMeijeren\ConvertToJUnitXML\Converters\Npm\Audit;

/**
 * Provides a class for ConvertNpmAuditCommandTest.
 *
 * @package tests\KoenVanMeijeren\ConvertToJUnitXML\Command
 */
final class ConvertNpmAuditCommandTest extends TestCase {
  private CommandTester $commandTester;

  protected function setUp(): void {
    $application = new Application();
    $application->add(new ConvertNpmAuditCommand(new Audit()));

    $command = $application->find('convert:npm-audit');
    $this->commandTester = new CommandTester($command);
  }

  public function testExecuteWithEmptyJson(): void {
    $this->commandTester->execute(
          [
            'input' => '{}',
          ]
      );

    self::assertEquals(
          '<?xml version="1.0" encoding="utf-8"?>
<testsuites>
  <testsuite name="npm audit" failures="0"/>
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
                  __DIR__ . '/../assets/npm-audit/multiple.json'
            ),
          ]
      );

    self::assertEquals(Command::FAILURE, $this->commandTester->getStatusCode());
  }

}
