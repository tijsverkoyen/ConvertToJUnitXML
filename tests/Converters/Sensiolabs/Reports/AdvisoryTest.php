<?php

namespace tests\KoenVanMeijeren\ConvertToJUnitXML\Converters\Sensiolabs\Reports;

use PHPUnit\Framework\TestCase;
use KoenVanMeijeren\ConvertToJUnitXML\Converters\Sensiolabs\Report\Advisory;

/**
 * Provides a class for AdvisoryTest.
 *
 * @package tests\KoenVanMeijeren\ConvertToJUnitXML\Converters\Sensiolabs\Reports
 */
final class AdvisoryTest extends TestCase {

  public function testCreationFromJson(): void {
    $json = new \stdClass();
    $json->title = 'title';
    $json->link = 'link';

    $advisory = Advisory::fromJson($json);

    self::assertEquals('title', $advisory->getTitle());
    self::assertEquals('link', $advisory->getLink());
  }

}
