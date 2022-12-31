<?php

declare(strict_types = 1);

namespace KoenVanMeijeren\ConvertToJUnitXML\Converters\Npm;

use KoenVanMeijeren\ConvertToJUnitXML\Converters\ConverterInterface;
use KoenVanMeijeren\ConvertToJUnitXML\Converters\Npm\Report\Advisory;
use KoenVanMeijeren\ConvertToJUnitXML\Converters\Npm\Report\Report;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\Failure;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\JUnit;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\TestCase;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\TestSuite;

/**
 * Provides a class for Audit.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\Converters\Npm
 */
final class Audit implements ConverterInterface {

  /**
   * {@inheritDoc}
   */
  public function convert(string $input): JUnit {
    $report = Report::fromString($input);
    $jUnit = new JUnit();
    $testSuite = new TestSuite('npm audit');

    foreach ($report->getAdvisories() as $advisory) {
      $testCase = new TestCase(
            sprintf(
                '%1$s has vulnerabilities',
                $advisory->getPackage()
            )
        );

      $testCase->addFailure(
            new Failure(
                'warning',
                $advisory->getTitle(),
                $this->buildDescription($advisory)
            )
        );

      $testSuite->addTestCase($testCase);
    }

    $jUnit->addTestSuite($testSuite);

    return $jUnit;
  }

  /**
   * Builds the description.
   */
  private function buildDescription(Advisory $advisory): string {
    $description = sprintf(
          '[%1$s] %2$s in package: %3$s',
          $advisory->getSeverity(),
          $advisory->getTitle(),
          $advisory->getPackage()
      );

    if ($advisory->hasPaths()) {
      $description .= "\n" . 'Infected paths:';
      foreach ($advisory->getPaths() as $path) {
        $description .= "\n" . '* ' . $path;
      }
      $description .= "\n";
    }

    $description .= "\n" . 'More information on: ' . $advisory->getUrl();

    return $description;
  }

}
