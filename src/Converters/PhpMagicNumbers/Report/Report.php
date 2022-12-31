<?php

declare(strict_types = 1);

namespace KoenVanMeijeren\ConvertToJUnitXML\Converters\PhpMagicNumbers\Report;

/**
 * Provides a class for Report.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\Converters\PhpMagicNumbers\Report
 */
final class Report {

  /**
   * Constructs a new object.
   *
   * @param string $version
   *   The version.
   * @param int $fileCount
   *   The file count.
   * @param int $errorCount
   *   The error count.
   * @param File[] $files
   *   The files.
   */
  public function __construct(
    public string $version,
    public int $fileCount,
    public int $errorCount,
    public array $files
  ) {}

  /**
   * Constructs the object from JSON.
   *
   * @throws \KoenVanMeijeren\ConvertToJUnitXML\Converters\Exceptions\InvalidInputException
   */
  public static function fromString(string $string): self {
    $data = simplexml_load_string($string);
    if ($data === FALSE) {
      throw new \InvalidArgumentException('Invalid XML data received');
    }

    $attributes = [];
    // @phpstan-ignore-next-line
    foreach ($data->attributes() as $key => $data_attribute) {
      $attributes[$key] = (string) $data_attribute;
    }

    /** @var File[] $files */
    $files = [];
    foreach ($data->files->file as $child) {
      $files[] = File::createFromXml($child);
    }

    return new self(
      $attributes['version'],
      (int) $attributes['fileCount'],
      (int) $attributes['errorCount'],
      $files
    );
  }

}
