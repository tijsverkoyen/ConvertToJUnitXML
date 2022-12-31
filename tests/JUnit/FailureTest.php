<?php

namespace tests\KoenVanMeijeren\ConvertToJUnitXML\JUnit;

use PHPUnit\Framework\TestCase;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\Failure;

/**
 * Provides a class for FailureTest.
 *
 * @package tests\KoenVanMeijeren\ConvertToJUnitXML\JUnit
 */
final class FailureTest extends TestCase {

  public function testXMLGeneration(): void {
    $type = 'type';
    $message = 'message';

    $failure = new Failure($type, $message);

    $document = new \DOMDocument();
    $node = $failure->toXml($document);
    assert($node instanceof \DOMElement);

    self::assertEquals('failure', $node->nodeName);

    self::assertTrue($node->hasAttribute('type'));
    self::assertEquals($type, $node->getAttribute('type'));

    self::assertTrue($node->hasAttribute('message'));
    self::assertEquals($message, $node->getAttribute('message'));
  }

}
