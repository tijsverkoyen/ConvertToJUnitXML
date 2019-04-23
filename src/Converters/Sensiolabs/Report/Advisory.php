<?php

namespace TijsVerkoyen\ConvertToJUnitXML\Converters\Sensiolabs\Report;

class Advisory
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $link;

    /**
     * @var string
     */
    private $cve;

    public function __construct(string $title, string $link, string $cve)
    {
        $this->title = $title;
        $this->link = $link;
        $this->cve = $cve;
    }

    public function getMessage(): string
    {
        return sprintf(
            '%1$s. More information on: %2$s',
            $this->title,
            $this->link
        );
    }

    public static function fromJson(\stdClass $json): Advisory
    {
        return new Advisory(
            $json->title,
            $json->link,
            $json->cve
        );
    }
}
