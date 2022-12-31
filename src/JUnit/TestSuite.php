<?php

namespace KoenVanMeijeren\ConvertToJUnitXML\JUnit;

/**
 * Provides a class for TestSuite.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\JUnit
 */
final class TestSuite {

  /**
   * The testCases.
   *
   * @var TestCase[]
   */
  private array $testCases = [];

  /**
   * Constructs a new object.
   */
  public function __construct(
    private string $name
  ) {
  }

  /**
   * Adds a test case.
   */
  public function addTestCase(TestCase $testCase): TestSuite {
    $this->testCases[] = $testCase;
    return $this;
  }

  /**
   * Gets the failure count.
   */
  public function getFailureCount(): int {
    $total = 0;
    foreach ($this->testCases as $testCase) {
      $total += count($testCase->getFailures());
    }

    return $total;
  }

  /**
   * Renders the object to XML.
   */
  public function toXml(\DOMDocument $document): \DOMNode {
    $node = $document->createElement('testsuite');
    $node->setAttribute('name', $this->name);
    $node->setAttribute('failures', (string) $this->getFailureCount());

    foreach ($this->testCases as $testCase) {
      $node->appendChild($testCase->toXml($document));
    }

    return $node;
  }

}
