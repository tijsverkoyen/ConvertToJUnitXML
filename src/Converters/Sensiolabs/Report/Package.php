<?php

namespace KoenVanMeijeren\ConvertToJUnitXML\Converters\Sensiolabs\Report;

/**
 * Provides a class for Package.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\Converters\Sensiolabs\Report
 */
final class Package {

  /**
   * Constructs a new object.
   *
   * @param string $name
   *   The name.
   * @param string $version
   *   The version.
   * @param Advisory[] $advisories
   *   The advisories.
   */
  public function __construct(
    private string $name,
    private string $version,
    private array $advisories
  ) {
  }

  /**
   * Gets the name.
   */
  public function getName(): string {
    return $this->name;
  }

  /**
   * Gets the version.
   */
  public function getVersion(): string {
    return $this->version;
  }

  /**
   * Gets the advisories.
   *
   * @return Advisory[]
   *   The advisories.
   */
  public function getAdvisories(): array {
    return $this->advisories;
  }

  /**
   * Creates the object from JSON.
   */
  public static function fromJson(string $name, \stdClass $json): self {
    $advisories = [];
    foreach ($json->advisories as $advisory) {
      $advisories[] = Advisory::fromJson($advisory);
    }

    return new self(
          $name,
          $json->version,
          $advisories
      );
  }

}
