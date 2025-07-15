<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase;

use function Hexlet\Code\genDiff;

class GenDiffTest extends TestCase
{
    public function testGenDiffJson()
    {
        $expected = file_get_contents(__DIR__ . "/fixtures/expectedFlat");
        $jsonPath1 = __DIR__ . "/fixtures/file1.json";
        $jsonPath2 = __DIR__ . "/fixtures/file2.json";

        $result = genDiff($jsonPath1, $jsonPath2);

        $this->assertEquals($result, $expected);
    }

    public function testGenDiffYml()
    {
        $expected = file_get_contents(__DIR__ . "/fixtures/expectedFlat");
        $yamlPath1 = __DIR__ . "/fixtures/file1.yml";
        $yamlPath2 = __DIR__ . "/fixtures/file2.yaml";

        $result = genDiff($yamlPath1, $yamlPath2);

        $this->assertEquals($result, $expected);
    }
}
