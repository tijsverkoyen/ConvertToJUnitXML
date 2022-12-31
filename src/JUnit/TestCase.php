<?php

declare(strict_types = 1);

namespace KoenVanMeijeren\ConvertToJUnitXML\JUnit;

/**
 * Provides a class for TestCase.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\JUnit
 */
final class TestCase {
  /**
   * The failures.
   *
   * @var Failure[]
   */
  private array $failures = [];

  /**
   * Constructs a new object.
   */
  public function __construct(
    private string $name
  ) {
  }

  /**
   * Gets the Name.
   */
  public function getName(): string {
    return $this->name;
  }

  /**
   * Adds a failure.
   */
  public function addFailure(Failure $failure): TestCase {
    $this->failures[] = $failure;
    return $this;
  }

  /**
   * Function for getFailures.
   *
   * @return Failure[]
   *   The failures.
   */
  public function getFailures(): array {
    return $this->failures;
  }

  /**
   * Renders the object to XML.
   */
  public function toXml(\DOMDocument $document): \DOMNode {
    $node = $document->createElement('testcase');
    $node->setAttribute('name', $this->name);
    $node->setAttribute('failures', (string) count($this->failures));

    foreach ($this->failures as $failure) {
      $node->appendChild($failure->toXml($document));
    }

    return $node;
  }

}
