<?php

namespace tests\TijsVerkoyen\ConvertToJUnitXML\Converters\Npm\Report;

use PHPUnit\Framework\TestCase;
use TijsVerkoyen\ConvertToJUnitXML\Converters\Npm\Report\Advisory;

class AdvisoryTest extends TestCase
{
    public function testCreationFromJson()
    {
        $finding = new \stdClass();
        $finding->paths = [
            'path 1',
            'path 2',
        ];

        $json = new \stdClass();
        $json->title = 'title';
        $json->module_name = 'module_name';
        $json->recommendation = 'recommendation';
        $json->severity = 'severity';
        $json->url = 'url';
        $json->findings = [
            $finding
        ];

        $advisory = Advisory::fromJson($json);

        $this->assertEquals(
            'module_name',
            $advisory->getPackage()
        );

        $this->assertEquals(
            ['path 1', 'path 2'],
            $advisory->getPaths()
        );

        $this->assertEquals(
            'title',
            $advisory->getTitle()
        );
    }
}
