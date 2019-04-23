<?php

namespace tests\TijsVerkoyen\ConvertToJUnitXML\JUnit;

use PHPUnit\Framework\TestCase;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\Failure;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\TestSuite;

class TestCaseTest extends TestCase
{
    public function testXMLGeneration(): void
    {
        $name = 'name';

        $testCase = new \TijsVerkoyen\ConvertToJUnitXML\JUnit\TestCase($name);

        $document = new \DOMDocument();
        $node = $testCase->toXML($document);

        $this->assertEquals('testcase', $node->nodeName);

        $this->assertTrue($node->hasAttribute('name'));
        $this->assertEquals($name, $node->getAttribute('name'));

        $this->assertTrue($node->hasAttribute('failures'));
        $this->assertEquals(0, $node->getAttribute('failures'));

        $this->assertTrue($node->hasAttribute('tests'));
        $this->assertEquals(0, $node->getAttribute('tests'));
    }

    public function testXMLGenerationWithFailures(): void
    {
        $name = 'name';

        $testCase = new \TijsVerkoyen\ConvertToJUnitXML\JUnit\TestCase($name);

        $testCase->addFailure(new Failure('error', 'message'));
        $testCase->addFailure(new Failure('error', 'message'));

        $document = new \DOMDocument();
        $node = $testCase->toXML($document);

        $this->assertEquals('testcase', $node->nodeName);

        $this->assertTrue($node->hasAttribute('name'));
        $this->assertEquals($name, $node->getAttribute('name'));

        $this->assertTrue($node->hasAttribute('failures'));
        $this->assertEquals(2, $node->getAttribute('failures'));

        $this->assertTrue($node->hasAttribute('tests'));
        $this->assertEquals(2, $node->getAttribute('tests'));
    }
}
