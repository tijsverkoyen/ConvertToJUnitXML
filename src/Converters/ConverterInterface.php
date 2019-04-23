<?php

namespace TijsVerkoyen\ConvertToJUnitXML\Converters;

use TijsVerkoyen\ConvertToJUnitXML\JUnit\JUnit;

interface ConverterInterface
{
    public function convert(string $input): JUnit;
}
