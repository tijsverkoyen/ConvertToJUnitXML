<?php

namespace tests\KoenVanMeijeren\ConvertToJUnitXML\Converters\Npm\Report;

use PHPUnit\Framework\TestCase;
use KoenVanMeijeren\ConvertToJUnitXML\Converters\Npm\Report\Advisory;

/**
 * Provides a class for AdvisoryTest.
 *
 * @package tests\KoenVanMeijeren\ConvertToJUnitXML\Converters\Npm\Report
 */
final class AdvisoryTest extends TestCase {

  public function testCreationFromJson(): void {
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
      $finding,
    ];

    $advisory = Advisory::fromJson($json);

    self::assertEquals('module_name', $advisory->getPackage());
    self::assertEquals(['path 1', 'path 2'], $advisory->getPaths());
    self::assertEquals('title', $advisory->getTitle());
  }

}
