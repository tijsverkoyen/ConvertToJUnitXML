<?php

namespace tests\TijsVerkoyen\ConvertToJUnitXML\Converters\Sensiolabs\Report;

use PHPUnit\Framework\TestCase;
use TijsVerkoyen\ConvertToJUnitXML\Converters\Sensiolabs\Report\Package;

class PackageTest extends TestCase
{
    public function testCreationFromJson()
    {
        $advisory1 = new \stdClass();
        $advisory1->title = 'title';
        $advisory1->link = 'link';
        $advisory1->cve = 'cve';

        $advisories = [
            $advisory1
        ];

        $json = new \stdClass();
        $json->version = 'version';
        $json->advisories = $advisories;

        $package = Package::fromJson('name', $json);

        $this->assertEquals('name', $package->getName());
        $this->assertEquals('version', $package->getVersion());
    }
}
