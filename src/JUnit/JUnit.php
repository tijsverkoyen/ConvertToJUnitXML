<?php

declare(strict_types = 1);

namespace KoenVanMeijeren\ConvertToJUnitXML\JUnit;

/**
 * Provides a class for JUnit.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\JUnit
 */
final class JUnit {
  public const DOM_DOCUMENT_VERSION = '1.0';

  /**
   * The testSuites.
   *
   * @var TestSuite[]
   */
  private array $testSuites = [];

  /**
   * Adds a test suite.
   */
  public function addTestSuite(TestSuite $testSuite): JUnit {
    $this->testSuites[] = $testSuite;
    return $this;
  }

  /**
   * Gets the test suites.
   *
   * @return TestSuite[]
   *   The test suites.
   */
  public function getTestSuites(): array {
    return $this->testSuites;
  }

  /**
   * Determines if there are failures.
   */
  public function hasFailures(): bool {
    if ($this->testSuites === []) {
      return FALSE;
    }

    foreach ($this->testSuites as $testSuite) {
      if ($testSuite->getFailureCount() > 0) {
        return TRUE;
      }
    }

    return FALSE;
  }

  /**
   * Renders the data to XML.
   */
  public function toXml(): \DOMDocument {
    $document = new \DOMDocument(self::DOM_DOCUMENT_VERSION, 'utf-8');
    $document->formatOutput = TRUE;

    $testSuites = $document->createElement('testsuites');
    $document->appendChild($testSuites);

    foreach ($this->testSuites as $testSuite) {
      $testSuites->appendChild($testSuite->toXml($document));
    }
    return $document;
  }

  /**
   * Renders the XML to string.
   */
  public function __toString(): string {
    return (string) $this->toXml()->saveXML();
  }

}
