<?php

namespace TijsVerkoyen\ConvertToJUnitXML\JUnit;

class Failure
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $message;

    public function __construct(string $type, string $message)
    {
        $this->type = $type;
        $this->message = $message;
    }

    public function toXML(\DOMDocument $document): \DOMNode
    {
        $node = $document->createElement('failure');
        $node->setAttribute('type', $this->type);
        $node->setAttribute('message', $this->message);

        return $node;
    }
}
