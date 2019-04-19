<?php

namespace TijsVerkoyen\ConvertToJUnitXML\JUnit;

class TestCase
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $failures = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function addFailure(Failure $failure): TestCase
    {
        $this->failures[] = $failure;
        return $this;
    }

    public function getFailures(): array
    {
        return $this->failures;
    }

    public function toXML(\DOMDocument $document): \DOMNode
    {
        $node = $document->createElement('testcase');
        $node->setAttribute('name', $this->name);
        $node->setAttribute('failures', count($this->failures));
        $node->setAttribute('tests', count($this->failures));

        foreach ($this->failures as $failure) {
            $node->appendChild($failure->toXML($document));
        }

        return $node;
    }
}
