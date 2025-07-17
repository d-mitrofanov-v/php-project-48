<?php

namespace Hexlet\Code;

use Symfony\Component\Yaml\Yaml;

function getFileContent($filePath, $fileFormat)
{
    $fileContent = file_get_contents($filePath);

    $parsers = match ($fileFormat) {
        'json' => fn ($fileContent) => json_decode($fileContent, true),
        'yml', 'yaml' => fn($fileContent) => Yaml::parse($fileContent)
    };

    return $parsers($fileContent);
}
