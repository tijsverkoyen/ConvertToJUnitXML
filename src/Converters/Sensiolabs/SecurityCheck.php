<?php

namespace KoenVanMeijeren\ConvertToJUnitXML\Converters\Sensiolabs;

use KoenVanMeijeren\ConvertToJUnitXML\Converters\ConverterInterface;
use KoenVanMeijeren\ConvertToJUnitXML\Converters\Sensiolabs\Report\Report;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\Failure;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\JUnit;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\TestCase;
use KoenVanMeijeren\ConvertToJUnitXML\JUnit\TestSuite;

/**
 * Provides a class for SecurityCheck.
 *
 * @package KoenVanMeijeren\ConvertToJUnitXML\Converters\Sensiolabs
 */
final class SecurityCheck implements ConverterInterface {

  /**
   * {@inheritDoc}
   */
  public function convert(string $input): JUnit {
    $report = Report::fromString($input);
    $jUnit = new JUnit();
    $testSuite = new TestSuite('security-checker security:check');

    foreach ($report->getPackages() as $package) {
      $testCase = new TestCase(
            sprintf(
                '%1$s (%2$s) has vulnerabilities',
                $package->getName(),
                $package->getVersion()
            )
        );

      foreach ($package->getAdvisories() as $advisory) {
        $testCase->addFailure(
          new Failure(
              'error',
              $advisory->getTitle(),
              sprintf(
                  '%1$s' . "\n" . 'More information on: %2$s',
                  $advisory->getTitle(),
                  $advisory->getLink()
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
