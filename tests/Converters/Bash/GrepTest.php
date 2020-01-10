<?php

namespace tests\TijsVerkoyen\ConvertToJUnitXML\Converters\Bash;

use PHPUnit\Framework\TestCase;
use TijsVerkoyen\ConvertToJUnitXML\Converters\Bash\Grep;

class GrepTest extends TestCase
{
    public function testConversion(): void
    {
        $grep = new Grep();
        $jUnit = $grep->convert(
            file_get_contents(
                __DIR__ . '/../../assets/bash-grep/multiple.txt'
            )
        );

        $xml = $jUnit->toXML();
        $this->assertCount(1, $xml->getElementsByTagName('testsuite'));
    }

    public function testCreationFromEmptyString(): void
    {
        $grep = new Grep();
        $jUnit = $grep->convert('');

        $xml = $jUnit->toXML();
        $this->assertCount(1, $xml->getElementsByTagName('testsuite'));
        $this->assertCount(0, $xml->getElementsByTagName('testcase'));
    }
}