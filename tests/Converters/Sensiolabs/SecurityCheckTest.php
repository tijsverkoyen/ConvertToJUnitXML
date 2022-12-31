<?php

namespace tests\KoenVanMeijeren\ConvertToJUnitXML\Converters\Sensiolabs;

use PHPUnit\Framework\TestCase;
use KoenVanMeijeren\ConvertToJUnitXML\Converters\Sensiolabs\SecurityCheck;

/**
 * Provides a class for SecurityCheckTest.
 *
 * @package tests\KoenVanMeijeren\ConvertToJUnitXML\Converters\Sensiolabs
 */
final class SecurityCheckTest extends TestCase {

  public function testConversion(): void {
    $securityCheck = new SecurityCheck();
    $jUnit = $securityCheck->convert(
          (string) file_get_contents(
              __DIR__ . '/../../assets/sensiolabs-security-check/multiple.json'
          )
      );

    $xml = $jUnit->toXml();
    self::assertCount(1, $xml->getElementsByTagName('testsuite'));
  }

  public function testCreationFromEmptyJson(): void {
    $securityCheck = new SecurityCheck();
    $jUnit = $securityCheck->convert(
          (string) file_get_contents(
              __DIR__ . '/../../assets/sensiolabs-security-check/empty.json'
          )
      );

    $xml = $jUnit->toXml();
    self::assertCount(1, $xml->getElementsByTagName('testsuite'));
    self::assertCount(0, $xml->getElementsByTagName('testcase'));
  }

}
