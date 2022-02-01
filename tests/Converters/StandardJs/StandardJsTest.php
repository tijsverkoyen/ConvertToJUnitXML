<?php

namespace tests\TijsVerkoyen\ConvertToJUnitXML\Converters\Stylelint;

use PHPUnit\Framework\TestCase;
use TijsVerkoyen\ConvertToJUnitXML\Converters\Standardjs\Standardjs;

class StandardJsTest extends TestCase
{
    public function testConversion(): void
    {
        $standardJs = new StandardJs();
        $jUnit = $standardJs->convert(
            file_get_contents(
                __DIR__ . '/../../assets/standard-js/multiple.txt'
            )
        );

        $xml = $jUnit->toXML();
        $this->assertCount(1, $xml->getElementsByTagName('testsuite'));
    }
}
