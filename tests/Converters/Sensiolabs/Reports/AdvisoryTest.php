<?php

namespace tests\TijsVerkoyen\ConvertToJUnitXML\Converters\Sensiolabs\Report;

use PHPUnit\Framework\TestCase;
use TijsVerkoyen\ConvertToJUnitXML\Converters\Sensiolabs\Report\Advisory;

class AdvisoryTest extends TestCase
{
    public function testCreationFromJson()
    {
        $json = new \stdClass();
        $json->title = 'title';
        $json->link = 'link';
        $json->cve = 'cve';

        $advisory = Advisory::fromJson($json);

        $this->assertEquals(
            'title. More information on: link',
            $advisory->getMessage()
        );
    }
}
