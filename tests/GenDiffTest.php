<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase;

use function Hexlet\Code\genDiff;

class GenDiffTest extends TestCase
{
    public function testGenDiffFlatJson()
    {
        $expected = file_get_contents(__DIR__ . "/fixtures/flat/expectedFlat");
        $jsonPath1 = __DIR__ . "/fixtures/flat/fileFlat1.json";
        $jsonPath2 = __DIR__ . "/fixtures/flat/fileFlat2.json";

        $result = genDiff($jsonPath1, $jsonPath2);

        $this->assertEquals($result, $expected);
    }

    public function testGenDiffFlatYml()
    {
        $expected = file_get_contents(__DIR__ . "/fixtures/flat/expectedFlat");
        $yamlPath1 = __DIR__ . "/fixtures/flat/fileFlat1.yml";
        $yamlPath2 = __DIR__ . "/fixtures/flat/fileFlat2.yaml";

        $result = genDiff($yamlPath1, $yamlPath2);

        $this->assertEquals($result, $expected);
    }

    public function testGenDiffNestedJson()
    {
        $expected = file_get_contents(__DIR__ . "/fixtures/expectedNested");
        $jsonPath1 = __DIR__ . "/fixtures/fileNested1.json";
        $jsonPath2 = __DIR__ . "/fixtures/fileNested2.json";

        $result = genDiff($jsonPath1, $jsonPath2);

        $this->assertEquals($expected, $result);
    }
}
