<?php

declare(strict_types=1);

namespace KoenVanMeijeren\ConvertToJUnitXML\Converters\PhpMagicNumbers\Report;

/**
 * Provides a class for Entry.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\Converters\PhpMagicNumbers\Report;
 */
final class Entry {

  /**
   * Constructs a new object.
   */
  public function __construct(
    public string $line,
    public string $start,
    public string $end,
    public string $snippet
  ) {}

  /**
   * Creates the object from XML.
   */
  public static function createFromXml(\SimpleXMLElement $data): self {
    $attributes = [];
    // @phpstan-ignore-next-line
    foreach ($data->attributes() as $key => $data_attribute) {
      $attributes[$key] = (string) $data_attribute;
    }

    return new self(
      $attributes['line'],
      $attributes['start'],
      $attributes['end'],
      trim((string) $data->snippet)
    );
  }

}
