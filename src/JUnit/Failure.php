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

    /**
     * @var null|string
     */
    private $description;

    public function __construct(
        string $type,
        string $message,
        ?string $description = null
    ) {
        $this->type = $type;
        $this->message = $message;
        $this->description = $description;
    }

    public function toXML(\DOMDocument $document): \DOMNode
    {
        $node = $document->createElement('failure', $this->description);
        $node->setAttribute('type', $this->type);
        $node->setAttribute('message', $this->message);

        return $node;
    }
}
