<?php

namespace tests\KoenVanMeijeren\ConvertToJUnitXML\Converters\StandardJs;

use PHPUnit\Framework\TestCase;
use KoenVanMeijeren\ConvertToJUnitXML\Converters\StandardJs\StandardJs;

/**
 * Provides a class for StandardJsTest.
 *
 * @package tests\KoenVanMeijeren\ConvertToJUnitXML\Converters\StandardJs
 */
final class StandardJsTest extends TestCase {

  public function testConversion(): void {
    $standardJs = new StandardJs();
    $jUnit = $standardJs->convert(
          (string) file_get_contents(
              __DIR__ . '/../../assets/standard-js/multiple.txt'
          )
      );

    $xml = $jUnit->toXml();
    self::assertCount(1, $xml->getElementsByTagName('testsuite'));
  }

}
