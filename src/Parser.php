<?php

namespace Hexlet\Code;

use Symfony\Component\Yaml\Yaml;

function getFileContent($filePath, $fileFormat)
{
    $fileContent = file_get_contents($filePath);

    $map = [
        'json' => function ($fileContent) {
            $data = json_decode($fileContent);
            return get_object_vars($data);
        },
        'yml' => fn ($fileContent) => Yaml::parse($fileContent),
        'yaml' => fn ($fileContent) => Yaml::parse($fileContent)
    ];

    return $map[$fileFormat]($fileContent);
}
