<?php

namespace TijsVerkoyen\ConvertToJUnitXML\Converters\Npm;

use TijsVerkoyen\ConvertToJUnitXML\Converters\ConverterInterface;
use TijsVerkoyen\ConvertToJUnitXML\Converters\Npm\Report\Report;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\Failure;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\JUnit;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\TestCase;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\TestSuite;

class Audit implements ConverterInterface
{
    public function convert(string $input): JUnit
    {
        $report = Report::fromString($input);
        $advisories = $report->getAdvisories();

        $jUnit = new JUnit();

        if (empty($advisories)) {
            return $jUnit;
        }

        $testSuite = new TestSuite('npm audit');

        foreach ($report->getAdvisories() as $advisory) {
            $testCase = new TestCase(
                sprintf(
                    '%1$s in package: %2$s',
                    $advisory->getTitle(),
                    $advisory->getPackage()
                )
            );

            foreach ($advisory->getPaths() as $index => $path) {
                $testCase->addFailure(
                    new Failure(
                        'error',
                        $advisory->getMessage($index)
                    )
                );
            }

            $testSuite->addTestCase($testCase);
        }

        $jUnit->addTestSuite($testSuite);

        return $jUnit;
    }
}
