<?php

namespace KoenVanMeijeren\ConvertToJUnitXML\Converters;

use KoenVanMeijeren\ConvertToJUnitXML\JUnit\JUnit;

/**
 * Provides an interface for ConverterInterface.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\Converters
 */
interface ConverterInterface {

  /**
   * Converts the input to JUnit.
   *
   * @throws \JsonException
   * @throws \KoenVanMeijeren\ConvertToJUnitXML\Converters\Exceptions\InvalidInputException
   */
  public function convert(string $input): JUnit;

}
