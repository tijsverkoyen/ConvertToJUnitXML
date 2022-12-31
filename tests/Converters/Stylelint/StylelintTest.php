<?php

namespace tests\KoenVanMeijeren\ConvertToJUnitXML\Converters\Stylelint;

use PHPUnit\Framework\TestCase;
use KoenVanMeijeren\ConvertToJUnitXML\Converters\Stylelint\Stylelint;

/**
 * Provides a class for StylelintTest.
 *
 * @package tests\KoenVanMeijeren\ConvertToJUnitXML\Converters\Stylelint
 */
final class StylelintTest extends TestCase {

  public function testConversion(): void {
    $stylelint = new Stylelint();
    $jUnit = $stylelint->convert(
          (string) file_get_contents(
              __DIR__ . '/../../assets/stylelint/multiple.json'
          )
      );

    $xml = $jUnit->toXml();
    self::assertCount(1, $xml->getElementsByTagName('testsuite'));
  }

}
