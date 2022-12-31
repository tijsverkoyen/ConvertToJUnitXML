<?php

namespace tests\KoenVanMeijeren\ConvertToJUnitXML\JUnit;

use PHPUnit\Framework\TestCase;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\Failure;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\TestCase as JUnitTestCase;

/**
 * Provides a class for TestCaseTest.
 *
 * @package tests\KoenVanMeijeren\ConvertToJUnitXML\JUnit
 */
final class TestCaseTest extends TestCase {

  public function testXMLGeneration(): void {
    $name = 'name';

    $testCase = new JUnitTestCase($name);

    $document = new \DOMDocument();
    $node = $testCase->toXml($document);
    assert($node instanceof \DOMElement);

    self::assertEquals('testcase', $node->nodeName);

    self::assertTrue($node->hasAttribute('name'));
    self::assertEquals($name, $node->getAttribute('name'));

    self::assertTrue($node->hasAttribute('failures'));
    self::assertEquals(0, $node->getAttribute('failures'));
  }

  public function testXMLGenerationWithFailures(): void {
    $name = 'name';

    $testCase = new JUnitTestCase($name);

    $testCase->addFailure(new Failure('error', 'message'));
    $testCase->addFailure(new Failure('error', 'message'));

    $document = new \DOMDocument();
    $node = $testCase->toXml($document);
    assert($node instanceof \DOMElement);

    self::assertEquals('testcase', $node->nodeName);

    self::assertTrue($node->hasAttribute('name'));
    self::assertEquals($name, $node->getAttribute('name'));

    self::assertTrue($node->hasAttribute('failures'));
    self::assertEquals(2, $node->getAttribute('failures'));
  }

}
