<?php

namespace TijsVerkoyen\ConvertToJUnitXML\Converters\Sensiolabs\Report;

class Package
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $version;

    /**
     * @var array
     */
    private $advisories = [];

    public function __construct(
        string $name,
        string $version,
        array $advisories
    ) {
        $this->name = $name;
        $this->version = $version;
        $this->advisories = $advisories;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return Advisory[]
     */
    public function getAdvisories(): array
    {
        return $this->advisories;
    }

    public static function fromJson(string $name, \stdClass $json): Package
    {
        $advisories = [];
        foreach ($json->advisories as $advisory) {
            $advisories[] = Advisory::fromJson($advisory);
        }

        return new static(
            $name,
            $json->version,
            $advisories
        );
    }
}
