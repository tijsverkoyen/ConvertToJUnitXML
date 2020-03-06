<?php

namespace tests\TijsVerkoyen\ConvertToJUnitXML\Converters\Stylelint;

use PHPUnit\Framework\TestCase;
use TijsVerkoyen\ConvertToJUnitXML\Converters\Stylelint\Stylelint;

class StylelintTest extends TestCase
{
    public function testConversion(): void
    {
        $stylelint = new Stylelint();
        $jUnit = $stylelint->convert(
            file_get_contents(
                __DIR__ . '/../../assets/stylelint/multiple.json'
            )
        );

        $xml = $jUnit->toXML();
        $this->assertCount(1, $xml->getElementsByTagName('testsuite'));
    }
}
