<?php

namespace tests\KoenVanMeijeren\ConvertToJUnitXML\Converters\Npm\Report;

use PHPUnit\Framework\TestCase;
use KoenVanMeijeren\ConvertToJUnitXML\Converters\Exceptions\InvalidInputException;
use KoenVanMeijeren\ConvertToJUnitXML\Converters\Npm\Report\Report;

/**
 * Provides a class for ReportTest.
 *
 * @package tests\KoenVanMeijeren\ConvertToJUnitXML\Converters\Npm\Report
 */
final class ReportTest extends TestCase {

  public function testCreationFromJson(): void {
    $report = Report::fromString(
          (string) file_get_contents(
              __DIR__ . '/../../../assets/npm-audit/multiple.json'
          )
      );

    self::assertCount(2, $report->getAdvisories());
  }

  public function testCreationFromEmptyJson(): void {
    $report = Report::fromString(
          (string) file_get_contents(
              __DIR__ . '/../../../assets/npm-audit/empty.json'
          )
      );

    self::assertEmpty($report->getAdvisories());
  }

  public function testCreationFromInvalidJson(): void {
    $this->expectException(InvalidInputException::class);
    Report::fromString('{invalid}');
  }

}
