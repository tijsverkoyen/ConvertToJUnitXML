<?php

namespace TijsVerkoyen\ConvertToJUnitXML\Converters\Sensiolabs;

use TijsVerkoyen\ConvertToJUnitXML\Converters\ConverterInterface;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\JUnit;

class SecurityCheck implements ConverterInterface
{
    public function convert(string $input): JUnit
    {
        return new JUnit();
    }
}
