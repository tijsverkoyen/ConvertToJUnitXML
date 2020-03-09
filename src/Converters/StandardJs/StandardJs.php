<?php

namespace TijsVerkoyen\ConvertToJUnitXML\Converters\StandardJs;

use TijsVerkoyen\ConvertToJUnitXML\Converters\ConverterInterface;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\Failure;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\JUnit;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\TestCase;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\TestSuite;

class StandardJs implements ConverterInterface
{
    public function convert(string $input): JUnit
    {
        $lines = explode("\n", $input);
        $jUnit = new JUnit();
        $testSuite = new TestSuite('standardjs');

        $unresolvedItems = [];
        foreach ($lines as $line) {
            $line = trim($line);

            $matches = [];
            preg_match('|^(.*):([0-9]*):([0-9]*):(.*)$|U', $line, $matches);

            if (count($matches) === 5) {
                list($match, $path, $lineNumber, $column, $text) = $matches;

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