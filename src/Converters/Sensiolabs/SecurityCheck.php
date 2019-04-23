<?php

namespace TijsVerkoyen\ConvertToJUnitXML\Converters\Sensiolabs;

use TijsVerkoyen\ConvertToJUnitXML\Converters\ConverterInterface;
use TijsVerkoyen\ConvertToJUnitXML\Converters\Sensiolabs\Report\Report;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\Failure;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\JUnit;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\TestCase;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\TestSuite;

class SecurityCheck implements ConverterInterface
{
    public function convert(string $input): JUnit
    {
        $report = Report::fromString($input);

        $jUnit = new JUnit();

        if (!$report->hasPackages()) {
            return $jUnit;
        }

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
                        $advisory->getMessage()
                    )
                );
            }

            $testSuite->addTestCase($testCase);
        }

        $jUnit->addTestSuite($testSuite);

        return $jUnit;
    }
}
