<?php

namespace KoenVanMeijeren\ConvertToJUnitXML\Converters\Stylelint;

use KoenVanMeijeren\ConvertToJUnitXML\Converters\ConverterInterface;
use KoenVanMeijeren\ConvertToJUnitXML\Helpers\JsonHelper;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\Failure;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\JUnit;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\TestCase;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\TestSuite;

/**
 * Provides a class for Stylelint.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\Converters\Stylelint
 */
final class Stylelint implements ConverterInterface {

  /**
   * {@inheritDoc}
   */
  public function convert(string $input): JUnit {
    $jUnit = new JUnit();
    $testSuite = new TestSuite('stylelint');

    $data = JsonHelper::decode($input);
    assert(is_array($data));
    foreach ($data as $file) {
      if (!$file->errored) {
        continue;
      }

      $testCase = new TestCase(
            sprintf(
                '%1$s has vulnerabilities',
                $file->source
            )
        );

      foreach ($file->warnings as $warning) {
        $testCase->addFailure(
          new Failure(
              'warning',
              sprintf(
                  '%1$s in %2$s on line: %3$s, column: %4$s.',
                  $warning->text,
                  $file->source,
                  $warning->line,
                  $warning->column
              ),
              sprintf(
                  '%1$s in %2$s on line: %3$s, column: %4$s.',
                  $warning->text,
                  $file->source,
                  $warning->line,
                  $warning->column
              )
          )
          );
      }

      foreach ($file->parseErrors as $error) {
        $testCase->addFailure(
          new Failure(
              'error',
              sprintf(
                  '%1$s in %2$s on line: %3$s, column: %4$s.',
                  $error->text,
                  $file->source,
                  $error->line,
                  $error->column
              ),
              sprintf(
                  '%1$s in %2$s on line: %3$s, column: %4$s.',
                  $error->text,
                  $file->source,
                  $error->line,
                  $error->column
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
