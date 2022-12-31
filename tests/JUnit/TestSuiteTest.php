<?php

namespace tests\KoenVanMeijeren\ConvertToJUnitXML\JUnit;

use PHPUnit\Framework\TestCase;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\Failure;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\TestSuite;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\TestCase as JUnitTestCase;

/**
 * Provides a class for TestSuiteTest.
 *
 * @package tests\KoenVanMeijeren\ConvertToJUnitXML\JUnit
 */
final class TestSuiteTest extends TestCase {

  public function testXMLGeneration(): void {
    $name = 'name';

    $testSuite = new TestSuite($name);

    $document = new \DOMDocument();
    $node = $testSuite->toXml($document);
    assert($node instanceof \DOMElement);

    self::assertEquals('testsuite', $node->nodeName);

    self::assertTrue($node->hasAttribute('name'));
    self::assertEquals($name, $node->getAttribute('name'));

    self::assertTrue($node->hasAttribute('failures'));
    self::assertEquals(0, $node->getAttribute('failures'));
  }

  public function testXMLGenerationWithFailures(): void {
    $name = 'name';

    $testCase = new JUnitTestCase('testcase');
    $testCase->addFailure(new Failure('error', 'message'));
    $testCase->addFailure(new Failure('error', 'message'));

    $testSuite = new TestSuite($name);
    $testSuite->addTestCase($testCase);

    $document = new \DOMDocument();
    $node = $testSuite->toXml($document);
    assert($node instanceof \DOMElement);

    self::assertEquals('testsuite', $node->nodeName);

    self::assertTrue($node->hasAttribute('name'));
    self::assertEquals($name, $node->getAttribute('name'));

    self::assertTrue($node->hasAttribute('failures'));
    self::assertEquals(2, $node->getAttribute('failures'));
  }

}
