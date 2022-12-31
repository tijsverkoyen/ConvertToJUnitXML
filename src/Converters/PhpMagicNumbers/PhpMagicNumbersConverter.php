<?php

declare(strict_types=1);

namespace KoenVanMeijeren\ConvertToJUnitXML\Converters\PhpMagicNumbers;

use KoenVanMeijeren\ConvertToJUnitXML\Converters\ConverterInterface;
use KoenVanMeijeren\ConvertToJUnitXML\Converters\PhpMagicNumbers\Report\Report;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\Failure;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\JUnit;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\TestCase;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\TestSuite;

/**
 * Provides a class for PhpMagicNumbersConverter.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\Converters\PhpMagicNumbers;
 */
final class PhpMagicNumbersConverter implements ConverterInterface {

  /**
   * {@inheritDoc}
   */
  public function convert(string $input): JUnit {
    $jUnit = new JUnit();
    $testSuite = new TestSuite('PHP Magic numbers scan result');
    $jUnit->addTestSuite($testSuite);

    $report = Report::fromString($input);
    foreach ($report->files as $file) {
      $testCase = new TestCase($file->path);

      $testSuite->addTestCase($testCase);
      foreach ($file->entries as $entry) {
        $testCase->addFailure(
          new Failure(
            'error',
            sprintf('Line %1$s, start %2$s, end %3$s', $entry->line, $entry->start, $entry->end),
            $entry->snippet
          )
        );
      }
    }

    return $jUnit;
  }

}
