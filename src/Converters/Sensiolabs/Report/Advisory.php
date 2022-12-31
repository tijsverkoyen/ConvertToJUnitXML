<?php

namespace KoenVanMeijeren\ConvertToJUnitXML\Converters\Sensiolabs\Report;

/**
 * Provides a class for Advisory.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\Converters\Sensiolabs\Report
 */
final class Advisory {

  /**
   * Constructs a new object.
   */
  public function __construct(
    private string $title,
    private string $link
  ) {
  }

  /**
   * Gets the title.
   */
  public function getTitle(): string {
    return $this->title;
  }

  /**
   * Gets the link.
   */
  public function getLink(): string {
    return $this->link;
  }

  /**
   * Constructs the object from JSON.
   */
  public static function fromJson(\stdClass $json): self {
    return new self($json->title, $json->link);
  }

}
