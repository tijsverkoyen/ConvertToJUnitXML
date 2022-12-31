<?php

declare(strict_types = 1);

namespace KoenVanMeijeren\ConvertToJUnitXML\JUnit;

/**
 * Provides a class for Failure.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\JUnit
 */
final class Failure {

  /**
   * Constructs a new object.
   */
  public function __construct(
    private string $type,
    private string $message,
    private string $description = ''
  ) {
  }

  /**
   * Gets the Type.
   */
  public function getType(): string {
    return $this->type;
  }

  /**
   * Gets the Message.
   */
  public function getMessage(): string {
    return $this->message;
  }

  /**
   * Gets the Description.
   */
  public function getDescription(): string {
    return $this->description;
  }

  /**
   * Renders the data to XML.
   */
  public function toXml(\DOMDocument $document): \DOMNode {
    $node = $document->createElement('failure', $this->description);
    $node->setAttribute('type', $this->type);
    $node->setAttribute('message', $this->message);

    return $node;
  }

}
