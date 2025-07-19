<?php

namespace Hexlet\Code;

use Symfony\Component\Yaml\Yaml;

function getFileContent(string $filePath, string $fileFormat): array
{
    $fileContent = file_get_contents($filePath);

    $parsers = match ($fileFormat) {
        'json' => fn ($fileContent) => json_decode($fileContent, true),
        'yml', 'yaml' => fn($fileContent) => Yaml::parse($fileContent),
        default => fn($fileContent) => []
    };

    return $parsers($fileContent);
}
