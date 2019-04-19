<?php

namespace tests\TijsVerkoyen\ConvertToJUnitXML\JUnit;

use PHPUnit\Framework\TestCase;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\Failure;

class FailureTest extends TestCase
{
    public function testXMLGeneration(): void
    {
        $type = 'type';
        $message = 'message';

        $failure = new Failure($type, $message);

        $document = new \DOMDocument();
        $node = $failure->toXML($document);

        $this->assertEquals('failure', $node->nodeName);

        $this->assertTrue($node->hasAttribute('type'));
        $this->assertEquals($type, $node->getAttribute('type'));

        $this->assertTrue($node->hasAttribute('message'));
        $this->assertEquals($message, $node->getAttribute('message'));
    }
}
