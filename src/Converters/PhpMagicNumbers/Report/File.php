<?php

declare(strict_types=1);

namespace KoenVanMeijeren\ConvertToJUnitXML\Converters\PhpMagicNumbers\Report;

/**
 * Provides a class for File.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\Converters\PhpMagicNumbers\Report;
 */
final class File {

  /**
   * Constructs a new object.
   *
   * @param string $path
   *   The path.
   * @param int $errors
   *   The amount of errors.
   * @param Entry[] $entries
   *   The entries.
   */
  public function __construct(
    public string $path,
    public int $errors,
    public array $entries
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

    /** @var Entry[] $entries */
    $entries = [];
    foreach ($data->entry as $entry) {
      $entries[] = Entry::createFromXml($entry);
    }

    return new self(
      $attributes['path'],
      (int) $attributes['errors'],
      $entries
    );
  }

}
