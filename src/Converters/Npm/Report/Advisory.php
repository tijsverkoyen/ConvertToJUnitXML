<?php

namespace KoenVanMeijeren\ConvertToJUnitXML\Converters\Npm\Report;

/**
 * Provides a class for Advisory.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\Converters\Npm\Report
 */
final class Advisory {

  /**
   * Constructs a new object.
   *
   * @param string $title
   *   The title.
   * @param string $package
   *   The package.
   * @param string $recommendation
   *   The recommendation.
   * @param string $severity
   *   The severity.
   * @param string $url
   *   The url.
   * @param string[]|null $paths
   *   The paths.
   */
  public function __construct(
    private string $title,
    private string $package,
    private string $recommendation,
    private string $severity,
    private string $url,
    private ?array $paths = NULL
  ) {
  }

  /**
   * Gets the title.
   */
  public function getTitle(): string {
    return $this->title;
  }

  /**
   * Gets the package.
   */
  public function getPackage(): string {
    return $this->package;
  }

  /**
   * Gets the recommendation.
   */
  public function getRecommendation(): string {
    return $this->recommendation;
  }

  /**
   * Gets the severity.
   */
  public function getSeverity(): string {
    return $this->severity;
  }

  /**
   * Gets the url.
   */
  public function getUrl(): string {
    return $this->url;
  }

  /**
   * Gets the paths.
   *
   * @return string[]
   *   The paths.
   */
  public function getPaths(): array {
    return (array) $this->paths;
  }

  /**
   * Determines if this object has paths.
   */
  public function hasPaths(): bool {
    return $this->paths !== NULL && $this->paths !== [];
  }

  /**
   * Creates the object from JSON.
   */
  public static function fromJson(\stdClass $json): self {
    $paths = $json->findings[0]->paths ?? NULL;

    return new self(
          $json->title,
          $json->module_name,
          $json->recommendation,
          $json->severity,
          $json->url,
          $paths
      );
  }

}
