<?php

namespace tests\TijsVerkoyen\ConvertToJUnitXML\Converters\Npm\Report;

use PHPUnit\Framework\TestCase;
use TijsVerkoyen\ConvertToJUnitXML\Converters\Exceptions\InvalidInputException;
use TijsVerkoyen\ConvertToJUnitXML\Converters\Npm\Report\Report;

class ReportTest extends TestCase
{
    public function testCreationFromJson(): void
    {
        $report = Report::fromString(
            file_get_contents(
                __DIR__ . '/../../../assets/npm-audit/multiple.json'
            )
        );

        $this->assertEquals(2, count($report->getAdvisories()));
    }

    public function testCreationFromEmptyJson(): void
    {
        $report = Report::fromString(
            file_get_contents(
                __DIR__ . '/../../../assets/npm-audit/empty.json'
            )
        );

        $this->assertEmpty($report->getAdvisories());
    }

    public function testCreationFromInvalidJson(): void
    {
        $this->expectException(InvalidInputException::class);
        Report::fromString('{invalid}');
    }
}
