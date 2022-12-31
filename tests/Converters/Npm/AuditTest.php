<?php

namespace tests\KoenVanMeijeren\ConvertToJUnitXML\Converters\Npm;

use PHPUnit\Framework\TestCase;
use KoenVanMeijeren\ConvertToJUnitXML\Converters\Npm\Audit;

/**
 * Provides a class for AuditTest.
 *
 * @package tests\KoenVanMeijeren\ConvertToJUnitXML\Converters\Npm
 */
final class AuditTest extends TestCase {

  public function testConversion(): void {
    $audit = new Audit();
    $jUnit = $audit->convert(
          (string) file_get_contents(
              __DIR__ . '/../../assets/npm-audit/multiple.json'
          )
      );

    $xml = $jUnit->toXml();
    self::assertCount(1, $xml->getElementsByTagName('testsuite'));
  }

  public function testCreationFromEmptyJson(): void {
    $audit = new Audit();
    $jUnit = $audit->convert(
          (string) file_get_contents(
              __DIR__ . '/../../assets/npm-audit/empty.json'
          )
      );

    $xml = $jUnit->toXml();
    self::assertCount(1, $xml->getElementsByTagName('testsuite'));
    self::assertCount(0, $xml->getElementsByTagName('testcase'));
  }

}
