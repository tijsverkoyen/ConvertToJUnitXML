<?php

namespace tests\TijsVerkoyen\ConvertToJUnitXML\Converters\Npm\Report;

use PHPUnit\Framework\TestCase;
use TijsVerkoyen\ConvertToJUnitXML\Converters\Npm\Audit;

class AuditTest extends TestCase
{
    public function testConversion(): void
    {
        $audit = new Audit();
        $jUnit = $audit->convert(
            file_get_contents(
                __DIR__ . '/../assets/npm-audit/multiple.json'
            )
        );

        $xml = $jUnit->toXML();
        $this->assertCount(1, $xml->getElementsByTagName('testsuite'));
    }

    public function testCreationFromEmptyJson(): void
    {
        $audit = new Audit();
        $jUnit = $audit->convert(
            file_get_contents(
                __DIR__ . '/../assets/npm-audit/empty.json'
            )
        );

        $xml = $jUnit->toXML();
        $this->assertCount(0, $xml->getElementsByTagName('testsuite'));
    }
}
