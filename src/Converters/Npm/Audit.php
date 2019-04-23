<?php

namespace TijsVerkoyen\ConvertToJUnitXML\Converters\Npm;

use TijsVerkoyen\ConvertToJUnitXML\Converters\ConverterInterface;
use TijsVerkoyen\ConvertToJUnitXML\Converters\Npm\Report\Advisory;
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

    private function buildDescription(Advisory $advisory): string
    {
        $description = sprintf(
            '[%1$s] %2$s in package: %3$s',
            $advisory->getSeverity(),
            $advisory->getTitle(),
            $advisory->getPackage()
        );

        if (!empty($advisory->getPaths())) {
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
