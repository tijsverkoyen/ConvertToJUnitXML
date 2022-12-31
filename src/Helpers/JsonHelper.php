<?php

declare(strict_types=1);

namespace KoenVanMeijeren\ConvertToJUnitXML\Helpers;

use KoenVanMeijeren\ConvertToJUnitXML\Converters\Exceptions\InvalidInputException;

/**
 * Provides a class for JsonHelper.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\Helpers;
 */
final class JsonHelper {
  public const JSON_DEPTH_MAXIMUM = 512;

  /**
   * Decodes the JSON to a mixed data type.
   *
   * @throws \KoenVanMeijeren\ConvertToJUnitXML\Converters\Exceptions\InvalidInputException
   */
  public static function decode(string $input): mixed {
    try {
      $data = json_decode($input, FALSE, self::JSON_DEPTH_MAXIMUM, JSON_THROW_ON_ERROR);
      if ($data === NULL) {
        throw InvalidInputException::invalidJson();
      }
    }
    catch (\Throwable) {
      throw InvalidInputException::invalidJson();
    }

    return $data;
  }

}
