<?php

namespace tests\KoenVanMeijeren\ConvertToJUnitXML\Converters\Sensiolabs\Reports;

use PHPUnit\Framework\TestCase;
use KoenVanMeijeren\ConvertToJUnitXML\Converters\Sensiolabs\Report\Package;

/**
 * Provides a class for PackageTest.
 *
 * @package tests\KoenVanMeijeren\ConvertToJUnitXML\Converters\Sensiolabs\Reports
 */
final class PackageTest extends TestCase {

  public function testCreationFromJson(): void {
    $advisory1 = new \stdClass();
    $advisory1->title = 'title';
    $advisory1->link = 'link';
    $advisory1->cve = 'cve';

    $advisories = [
      $advisory1,
    ];

    $json = new \stdClass();
    $json->version = 'version';
    $json->advisories = $advisories;

    $package = Package::fromJson('name', $json);

    self::assertEquals('name', $package->getName());
    self::assertEquals('version', $package->getVersion());
  }

}
