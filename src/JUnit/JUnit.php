<?php

namespace TijsVerkoyen\ConvertToJUnitXML\JUnit;

class JUnit
{
    /**
     * @var array
     */
    private $testSuites = [];

    public function addTestSuite(TestSuite $testSuite): JUnit
    {
        $this->testSuites[] = $testSuite;
        return $this;
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
