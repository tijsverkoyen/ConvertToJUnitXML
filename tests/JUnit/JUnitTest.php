<?php

namespace tests\KoenVanMeijeren\ConvertToJUnitXML\JUnit;

use PHPUnit\Framework\TestCase;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\JUnit;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\TestSuite;

/**
 * Provides a class for JUnitTest.
 *
 * @package tests\KoenVanMeijeren\ConvertToJUnitXML\JUnit
 */
final class JUnitTest extends TestCase {

  public function testXMLGeneration(): void {
    $testSuite = new TestSuite('testsuite');

    $jUnit = new JUnit();
    $jUnit->addTestSuite($testSuite);

    $node = $jUnit->toXml();

    self::assertCount(1, $node->getElementsByTagName('testsuites'));
  }

  public function testStringGeneration(): void {
    $testSuite = new TestSuite('testsuite');

    $jUnit = new JUnit();
    $jUnit->addTestSuite($testSuite);

    self::assertEquals(
          "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<testsuites>
  <testsuite name=\"testsuite\" failures=\"0\"/>
</testsuites>
",
          (string) $jUnit
      );
  }

}
