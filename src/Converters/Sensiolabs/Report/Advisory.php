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

    public function __construct(string $title, string $link)
    {
        $this->title = $title;
        $this->link = $link;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public static function fromJson(\stdClass $json): Advisory
    {
        return new Advisory(
            $json->title,
            $json->link
        );
    }
}
