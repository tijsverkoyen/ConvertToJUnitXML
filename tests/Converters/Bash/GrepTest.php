<?php

namespace tests\KoenVanMeijeren\ConvertToJUnitXML\Converters\Bash;

use PHPUnit\Framework\TestCase;
use KoenVanMeijeren\ConvertToJUnitXML\Converters\Bash\Grep;

/**
 * Provides a class for GrepTest.
 *
 * @package tests\KoenVanMeijeren\ConvertToJUnitXML\Converters\Bash
 */
final class GrepTest extends TestCase {

  public function testConversion(): void {
    $grep = new Grep();
    $jUnit = $grep->convert(
          (string) file_get_contents(
              __DIR__ . '/../../assets/bash-grep/multiple.txt'
          )
      );

    $xml = $jUnit->toXml();
    self::assertCount(1, $xml->getElementsByTagName('testsuite'));
  }

  public function testCreationFromEmptyString(): void {
    $grep = new Grep();
    $jUnit = $grep->convert('');

    $xml = $jUnit->toXml();
    self::assertCount(1, $xml->getElementsByTagName('testsuite'));
    self::assertCount(0, $xml->getElementsByTagName('testcase'));
  }

}
