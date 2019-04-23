<?php

namespace TijsVerkoyen\ConvertToJUnitXML\JUnit;

class JUnit
{
    /**
     * @var TestSuite[]
     */
    private $testSuites = [];

    public function addTestSuite(TestSuite $testSuite): JUnit
    {
        $this->testSuites[] = $testSuite;
        return $this;
    }

    public function hasFailures(): bool
    {
        if (empty($this->testSuites)) {
            return false;
        }

        foreach ($this->testSuites as $testSuite) {
            if ($testSuite->getFailureCount() > 0) {
                return true;
            }
        }

        return false;
    }

    public function toXML(): \DOMDocument
    {
        $document = new \DOMDocument('1.0', 'utf-8');
        $document->formatOutput = true;

        $testSuites = $document->createElement('testsuites');
        $document->appendChild($testSuites);

        foreach ($this->testSuites as $testSuite) {
            $testSuites->appendChild($testSuite->toXML($document));
        }
        return $document;
    }

    public function __toString()
    {
        return $this->toXML()->saveXML();
    }
}
