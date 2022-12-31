<?php

namespace KoenVanMeijeren\ConvertToJUnitXML\Converters\Sensiolabs\Report;

use KoenVanMeijeren\ConvertToJUnitXML\Helpers\JsonHelper;

/**
 * Provides a class for Report.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\Converters\Sensiolabs\Report
 */
final class Report {

  /**
   * Constructs a new object.
   *
   * @param Package[] $packages
   *   The packages.
   */
  public function __construct(
        private array $packages
    ) {
  }

  /**
   * Determines if this report has packages.
   */
  public function hasPackages(): bool {
    return $this->packages !== [];
  }

  /**
   * Gets the packages.
   *
   * @return Package[]
   *   The packages.
   */
  public function getPackages(): array {
    return $this->packages;
  }

  /**
   * Constructs the object from JSON.
   *
   * @throws \KoenVanMeijeren\ConvertToJUnitXML\Converters\Exceptions\InvalidInputException
   */
  public static function fromString(string $string): self {
    $data = JsonHelper::decode($string);

    $packages = [];
    foreach ($data as $packageName => $package) {
      $packages[] = Package::fromJson($packageName, $package);
    }

    return new self($packages);
  }

}
