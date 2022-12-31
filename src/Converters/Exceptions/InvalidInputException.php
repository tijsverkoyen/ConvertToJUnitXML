<?php

declare(strict_types = 1);

namespace KoenVanMeijeren\ConvertToJUnitXML\Converters\Exceptions;

/**
 * Provides a class for InvalidInputException.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\Converters\Exceptions
 */
final class InvalidInputException extends \Exception {

  /**
   * Creates the invalid JSON exception.
   */
  public static function invalidJson(): self {
    return new self('Invalid input: invalid JSON');
  }

}
