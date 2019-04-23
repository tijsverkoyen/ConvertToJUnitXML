<?php

namespace tests\TijsVerkoyen\ConvertToJUnitXML\JUnit;

use PHPUnit\Framework\TestCase;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\Failure;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\TestSuite;

class TestSuiteTest extends TestCase
{
    public function testXMLGeneration(): void
    {
        $name = 'name';

        $testSuite = new TestSuite($name);

        $document = new \DOMDocument();
        $node = $testSuite->toXML($document);

        $this->assertEquals('testsuite', $node->nodeName);

        $this->assertTrue($node->hasAttribute('name'));
        $this->assertEquals($name, $node->getAttribute('name'));

        $this->assertTrue($node->hasAttribute('failures'));
        $this->assertEquals(0, $node->getAttribute('failures'));
    }

    public function testXMLGenerationWithFailures(): void
    {
        $name = 'name';

        $testCase = new \TijsVerkoyen\ConvertToJUnitXML\JUnit\TestCase(
            'testcase'
        );
        $testCase->addFailure(new Failure('error', 'message'));
        $testCase->addFailure(new Failure('error', 'message'));

        $testSuite = new TestSuite($name);
        $testSuite->addTestCase($testCase);

        $document = new \DOMDocument();
        $node = $testSuite->toXML($document);

        $this->assertEquals('testsuite', $node->nodeName);

        $this->assertTrue($node->hasAttribute('name'));
        $this->assertEquals($name, $node->getAttribute('name'));

        $this->assertTrue($node->hasAttribute('failures'));
        $this->assertEquals(2, $node->getAttribute('failures'));
    }
}
