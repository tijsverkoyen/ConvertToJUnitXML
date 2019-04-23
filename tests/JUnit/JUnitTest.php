<?php

namespace tests\TijsVerkoyen\ConvertToJUnitXML\JUnit;

use PHPUnit\Framework\TestCase;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\JUnit;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\TestSuite;

class JUnitTest extends TestCase
{
    public function testXMLGeneration(): void
    {
        $testSuite = new TestSuite('testsuite');

        $jUnit = new JUnit();
        $jUnit->addTestSuite($testSuite);

        $node = $jUnit->toXML();

        $this->assertEquals(
            1,
            count($node->getElementsByTagName('testsuites'))
        );
    }

    public function testStringGeneration(): void
    {
        $testSuite = new TestSuite('testsuite');

        $jUnit = new JUnit();
        $jUnit->addTestSuite($testSuite);

        $this->assertEquals(
            "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<testsuites>
  <testsuite name=\"testsuite\" failures=\"0\"/>
</testsuites>
",
            (string) $jUnit
        );
    }
}
