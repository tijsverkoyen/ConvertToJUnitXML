<?php

namespace TijsVerkoyen\ConvertToJUnitXML\JUnit;

class TestSuite
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $testCases = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function addTestCase(TestCase $testCase): TestSuite
    {
        $this->testCases[] = $testCase;
        return $this;
    }

    public function getFailureCount(): int
    {
        $total = 0;

        foreach ($this->testCases as $testCase) {
            $total += count($testCase->getFailures());
        }

        return $total;
    }

    public function toXML(\DOMDocument $document): \DOMNode
    {
        $node = $document->createElement('testsuite');
        $node->setAttribute('name', $this->name);
        $node->setAttribute('failures', $this->getFailureCount());

        foreach ($this->testCases as $testCase) {
            $node->appendChild($testCase->toXML($document));
        }

        return $node;
    }
}
