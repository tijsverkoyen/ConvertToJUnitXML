<?php

namespace TijsVerkoyen\ConvertToJUnitXML\Converters\Npm\Report;

use TijsVerkoyen\ConvertToJUnitXML\Converters\Exceptions\InvalidInputException;

class Report
{
    /**
     * @var Advisory[]
     */
    private $advisories = [];

    public function __construct(array $advisories)
    {
        $this->advisories = $advisories;
    }

    public function getAdvisories(): array
    {
        return $this->advisories;
    }

    public static function fromString(string $string): Report
    {
        $data = json_decode($string);
        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            throw InvalidInputException::invalidJSON();
        }

        if (!isset($data->advisories)) {
            return new static([]);
        }

        $advisories = [];
        foreach ($data->advisories as $advisory) {
            $advisories[] = Advisory::fromJson($advisory);
        }

        return new static($advisories);
    }
}
