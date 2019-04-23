<?php

namespace tests\TijsVerkoyen\ConvertToJUnitXML\Converters\Sensiolabs\Report;

use PHPUnit\Framework\TestCase;
use TijsVerkoyen\ConvertToJUnitXML\Converters\Exceptions\InvalidInputException;
use TijsVerkoyen\ConvertToJUnitXML\Converters\Sensiolabs\Report\Report;

class ReportTest extends TestCase
{
    public function testCreationFromJson(): void
    {
        $report = Report::fromString(
            file_get_contents(
                __DIR__ . '/../../../assets/sensiolabs-security-check/multiple.json'
            )
        );

        $this->assertEquals(3, count($report->getPackages()));
    }

    public function testCreationFromEmptyJson(): void
    {
        $report = Report::fromString(
            file_get_contents(
                __DIR__ . '/../../../assets/sensiolabs-security-check/empty.json'
            )
        );

        $this->assertEmpty($report->getPackages());
    }

    public function testCreationFromInvalidJson(): void
    {
        $this->expectException(InvalidInputException::class);
        Report::fromString('{invalid}');
    }
}
