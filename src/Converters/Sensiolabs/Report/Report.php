<?php

namespace TijsVerkoyen\ConvertToJUnitXML\Converters\Sensiolabs\Report;

use TijsVerkoyen\ConvertToJUnitXML\Converters\Exceptions\InvalidInputException;

class Report
{
    /**
     * @var array
     */
    private $packages = [];

    public function __construct(array $packages)
    {
        $this->packages = $packages;
    }

    public function hasPackages(): bool
    {
        return !empty($this->packages);
    }

    /**
     * @return Package[]
     */
    public function getPackages(): array
    {
        return $this->packages;
    }

    public static function fromString(string $string): Report
    {
        $data = json_decode($string);
        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            throw InvalidInputException::invalidJSON();
        }

        $packages = [];
        foreach ($data as $packageName => $package) {
            $packages[] = Package::fromJSON($packageName, $package);
        }

        return new static($packages);
    }
}
