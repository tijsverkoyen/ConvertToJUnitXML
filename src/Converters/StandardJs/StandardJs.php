<?php

namespace KoenVanMeijeren\ConvertToJUnitXML\Converters\StandardJs;

use KoenVanMeijeren\ConvertToJUnitXML\Converters\ConverterInterface;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\Failure;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\JUnit;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\TestCase;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\TestSuite;

/**
 * Provides a class for StandardJs.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\Converters\StandardJs
 */
final class StandardJs implements ConverterInterface {
  public const EXPECTED_PREG_MATCHES_COUNT = 5;

  /**
   * {@inheritDoc}
   */
  public function convert(string $input): JUnit {
    $lines = explode("\n", $input);
    $jUnit = new JUnit();
    $testSuite = new TestSuite('standardjs');

    $unresolvedItems = [];
    foreach ($lines as $line) {
      $line = trim($line);

      $matches = [];
      preg_match('|^(.*):([0-9]*):([0-9]*):(.*)$|U', $line, $matches);

      if (count($matches) === self::EXPECTED_PREG_MATCHES_COUNT) {
        [, $path, $lineNumber, , $text] = $matches;

        if (!array_key_exists($path, $unresolvedItems)) {
          $unresolvedItems[$path] = [];
        }

        $unresolvedItems[$path][$lineNumber] = $text;
      }
    }

    foreach ($unresolvedItems as $path => $failures) {
      $testCase = new TestCase(
            sprintf(
                '%1$s has unresolved items',
                $path
            )
        );

      foreach ($failures as $lineNumber => $text) {
        $testCase->addFailure(
          new Failure(
              'warning',
              sprintf(
                  'Match found in %1$s on line: %2$s.',
                  $path,
                  $lineNumber
              ),
              sprintf(
                  'The match is found on line %1$s in the string: %2$s',
                  $lineNumber,
                  trim($text)
              )
          )
          );
      }

      $testSuite->addTestCase($testCase);
    }

    $jUnit->addTestSuite($testSuite);

    return $jUnit;
  }

}
