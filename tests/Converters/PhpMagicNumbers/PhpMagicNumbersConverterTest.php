<?php

declare(strict_types=1);

namespace tests\KoenVanMeijeren\ConvertToJUnitXML\Converters\PhpMagicNumbers;

use KoenVanMeijeren\ConvertToJUnitXML\Converters\PhpMagicNumbers\PhpMagicNumbersConverter;
use PHPUnit\Framework\TestCase;

/**
 * Provides a class for PhpMagicNumbersConverterTest.
 *
 * @package tests\KoenVanMeijeren\ConvertToJUnitXML\Converters\PhpMagicNumbers;
 * @covers \KoenVanMeijeren\ConvertToJUnitXML\Converters\PhpMagicNumbers\PhpMagicNumbersConverter
 */
final class PhpMagicNumbersConverterTest extends TestCase {

  public function testConversion(): void {
    // Arrange
    $service = new PhpMagicNumbersConverter();

    // Act
    $jUnit = $service->convert(
      (string) file_get_contents(
        __DIR__ . '/../../assets/php-magic-numbers/multiple.xml'
      )
    );
    $testSuites = $jUnit->getTestSuites();
    $testCases = $testSuites[0]->getTestCases();
    $xml = $jUnit->toXml();

    // Assert
    self::assertCount(1, $xml->getElementsByTagName('testsuite'));
    self::assertCount(1, $testSuites);
    self::assertEquals(3, $testSuites[0]->getFailureCount());
    self::assertEquals('Interfaces/Controllers/ChatController.php', $testCases[0]->getName());
    self::assertCount(2, $testCases[0]->getFailures());
    self::assertEquals("error", $testCases[0]->getFailures()[0]->getType());
    self::assertEquals("Line 39, start 12, end 13", $testCases[0]->getFailures()[0]->getMessage());
    self::assertEquals("if (2 > 3) {", $testCases[0]->getFailures()[0]->getDescription());
    self::assertEquals("Line 39, start 16, end 17", $testCases[0]->getFailures()[1]->getMessage());
    self::assertEquals("if (2 > 3) {", $testCases[0]->getFailures()[1]->getDescription());
    self::assertEquals('Domain/Chat/Repository/ChatRepository.php', $testCases[1]->getName());
    self::assertCount(1, $testCases[1]->getFailures());
  }

  public function testEmptyConversion(): void {
    // Arrange
    $service = new PhpMagicNumbersConverter();

    // Act
    $jUnit = $service->convert(
      (string) file_get_contents(
        __DIR__ . '/../../assets/php-magic-numbers/empty.xml'
      )
    );
    $testSuites = $jUnit->getTestSuites();
    $testCases = $testSuites[0]->getTestCases();
    $xml = $jUnit->toXml();

    // Assert
    self::assertCount(1, $xml->getElementsByTagName('testsuite'));
    self::assertCount(1, $testSuites);
    self::assertCount(0, $testCases);
  }

}
