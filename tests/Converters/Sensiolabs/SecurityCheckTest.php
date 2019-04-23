<?php

namespace tests\TijsVerkoyen\ConvertToJUnitXML\Converters\Sensiolabs;

use PHPUnit\Framework\TestCase;
use TijsVerkoyen\ConvertToJUnitXML\Converters\Sensiolabs\SecirtyCheck;
use TijsVerkoyen\ConvertToJUnitXML\Converters\Sensiolabs\SecurityCheck;

class SecurityCheckTest extends TestCase
{
    public function testConversion(): void
    {
        $securityCheck = new SecurityCheck();
        $jUnit = $securityCheck->convert(
            file_get_contents(
                __DIR__ . '/../../assets/sensiolabs-security-check/multiple.json'
            )
        );

        $xml = $jUnit->toXML();
        $this->assertCount(1, $xml->getElementsByTagName('testsuite'));
    }

    public function testCreationFromEmptyJson(): void
    {
        $securityCheck = new SecurityCheck();
        $jUnit = $securityCheck->convert(
            file_get_contents(
                __DIR__ . '/../../assets/sensiolabs-security-check/empty.json'
            )
        );

        $xml = $jUnit->toXML();
        $this->assertCount(0, $xml->getElementsByTagName('testsuite'));
    }
}
