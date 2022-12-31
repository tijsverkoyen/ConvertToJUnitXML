<?php

declare(strict_types = 1);

namespace KoenVanMeijeren\ConvertToJUnitXML\Converters\Npm\Report;

use KoenVanMeijeren\ConvertToJUnitXML\Helpers\JsonHelper;

/**
 * Provides a class for Report.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\Converters\Npm\Report
 */
final class Report {

  /**
   * Constructs a new object.
   *
   * @param Advisory[] $advisories
   *   The advisories.
   */
  public function __construct(
    private array $advisories
  ) {
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
   *
   * @throws \KoenVanMeijeren\ConvertToJUnitXML\Converters\Exceptions\InvalidInputException
   */
  public static function fromString(string $string): self {
    $data = JsonHelper::decode($string);
    if (!isset($data->advisories)) {
      return new self([]);
    }

    $advisories = [];
    foreach ($data->advisories as $advisory) {
      $advisories[] = Advisory::fromJson($advisory);
    }

    return new self($advisories);
  }

}
