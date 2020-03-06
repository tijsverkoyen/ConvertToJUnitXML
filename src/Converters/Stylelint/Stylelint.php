<?php

namespace TijsVerkoyen\ConvertToJUnitXML\Converters\Stylelint;

use TijsVerkoyen\ConvertToJUnitXML\Converters\ConverterInterface;
use TijsVerkoyen\ConvertToJUnitXML\Converters\Exceptions\InvalidInputException;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\Failure;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\JUnit;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\TestCase;
use TijsVerkoyen\ConvertToJUnitXML\JUnit\TestSuite;

class Stylelint implements ConverterInterface
{
    public function convert(string $input): JUnit
    {
        $data = json_decode($input);

        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            throw InvalidInputException::invalidJSON();
        }

        $jUnit = new JUnit();
        $testSuite = new TestSuite('stylelint');

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