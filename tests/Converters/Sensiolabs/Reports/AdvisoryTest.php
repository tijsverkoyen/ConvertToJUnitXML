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

        $advisory = Advisory::fromJson($json);

        $this->assertEquals('title', $advisory->getTitle());
        $this->assertEquals('link', $advisory->getLink());
    }
}
