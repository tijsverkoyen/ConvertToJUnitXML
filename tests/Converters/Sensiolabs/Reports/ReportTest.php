<?php

namespace tests\KoenVanMeijeren\ConvertToJUnitXML\Converters\Sensiolabs\Reports;

use PHPUnit\Framework\TestCase;
use KoenVanMeijeren\ConvertToJUnitXML\Converters\Exceptions\InvalidInputException;
use KoenVanMeijeren\ConvertToJUnitXML\Converters\Sensiolabs\Report\Report;

/**
 * Provides a class for ReportTest.
 *
 * @package tests\KoenVanMeijeren\ConvertToJUnitXML\Converters\Sensiolabs\Reports
 */
final class ReportTest extends TestCase {

  public function testCreationFromJson(): void {
    $report = Report::fromString(
          (string) file_get_contents(
              __DIR__ . '/../../../assets/sensiolabs-security-check/multiple.json'
          )
      );

    self::assertCount(3, $report->getPackages());
  }

  public function testCreationFromEmptyJson(): void {
    $report = Report::fromString(
          (string) file_get_contents(
              __DIR__ . '/../../../assets/sensiolabs-security-check/empty.json'
          )
      );

    self::assertEmpty($report->getPackages());
  }

  public function testCreationFromInvalidJson(): void {
    $this->expectException(InvalidInputException::class);
    Report::fromString('{invalid}');
  }

}
