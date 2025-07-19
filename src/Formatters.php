<?php

namespace Hexlet\Code;

use function Hexlet\Code\Formatters\renderPlain;
use function Hexlet\Code\Formatters\renderStylish;
use function Hexlet\Code\Formatters\renderJson;

function getFormatter(array $data, string $format): string|false
{
    $renderer = match ($format) {
        'stylish' => fn($data) => renderStylish($data),
        'plain' => fn($data) => renderPlain($data),
        'json' => fn($data) => renderJson($data),
        default => fn($data) => ""
    };

    return $renderer($data);
}
